<?php
namespace App\Controller;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Device;
use App\Controller\AppController;
use Cake\Error\Debugger;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Controller\Component\AuthComponent;
use Cake\Datasource\ConnectionManager;
use Cake\Utility;
//use Cake\Network\Request // @author: Aleksandr
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     * @author Muneeb Noor
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Cities']
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * @author Touhidur Rahman, Norman Lista
     */
    public function view($id = null)
    {
        // if id is not supplied show own profile 
        if (!$id) $id = $this->Auth->user('id');
        $user = $this->Users->get($id);
        $propertiesTbl = TableRegistry::get('Properties');
        $query = $propertiesTbl->find()->where(['user_id' => $id]);
        // join zips.number field
        $query->contain(['Zips' => function($q){
            return $q->select('number', 'city', 'province');
        }]);
        $propertyCount = $query->count();
        $properties = $query->toList();

        //@author Norman Lista
        //send LogUser For verification of rating himself
        $logUser=$this->Auth->user('id');
        //for feedback
        $this->loadModel('Feedbacks');
        $feedback=$this->Feedbacks->newEntity();
        if($this->request->is('post')){
            $feedback= $this->Feedbacks->patchEntity($feedback,$this->request->data);
         if($this->Feedbacks->save($feedback)){
             $this->Flash->success(__('Feedback added'));
         }else{
             $this->Flash-error(__('Unable to add feedback'));
         }
        }
        $this->set('feedback',$feedback);
        $this->set(compact('user', 'properties', 'propertyCount', 'logUser'));
        $this->set('_serialize', ['user', 'properties', 'propertyCount']);
    }

    /**
     * Add method - add user profile image
     *@Mythri Manjunath
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($id=null)
    {   
        $user='';
        if ($this->request->is('post')) {
            if(!empty($this->request->data['photo']['name'])){
                $fileName = $this->request->data['photo']['name'];
                if(move_uploaded_file($this->request->data['photo']['tmp_name'],WWW_ROOT . 'img' . DS . 'users' . DS .$fileName)){  
                   if (!$id) $id = $this->Auth->user('id');
                    $user = $this->Users->get($id);
                    $user->photo = $fileName;                   
                    if ($this->Users->save($user)) {
                        $this->Flash->success(__('Image has been uploaded and inserted successfully.'));
                        return $this->redirect([
                        'controller' => 'Users',
                         'action' => 'view', $id
                       ]);
                    }else{
                        $this->Flash->error(__('Unable to upload image, please try again.'));
                    }
                }else{
                    $this->Flash->error(__('Unable to upload image, please try again.'));
                }
            }else{
                $this->Flash->error(__('Please choose a image to upload.'));
            }
            
        }
        $cities = $this->Users->Cities->find('list', ['limit' => 200]);
        $properties = $this->Users->Properties->find('list', ['limit' => 200]);
        $this->set(compact('user', 'cities', 'properties'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Properties']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $cities = $this->Users->Cities->find('list', ['limit' => 200]);
        $properties = $this->Users->Properties->find('list', ['limit' => 200]);
        $this->set(compact('user', 'cities', 'properties'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    /**
     * @author Muneeb Noor
     */
	public function login()
	{


		if($this->request->is('post'))
		{
			$user = $this->Auth->identify();

            if($user)
			{
				$this->Auth->setUser($user);

				if($this->request->data('remember_me')) {
					$this->Cookie->configKey('CookieAuth', [
						'expires' => '+1 month',
						'httpOnly' => true
					]);
					$this->Cookie->write('CookieAuth', [
						'username' => $this->request->data('username'),
						'password' => (new DefaultPasswordHasher)->hash($this->request->data('password'))
					]);
				}
				if($user['status']==9)
                {
                    return $this->redirect(['controller' => 'users','action' => 'admin']);
                }
				return $this->redirect(['controller' => 'users','action' => 'dashboard']);

			}else{
                         $this->Flash->error('Username or password is incorrect');
                        }



		}
	}

    /**
     * @author Muneeb Noor
     */
	public function register()
	{
		$user = $this->Users->newEntity();
		if($this->request->is('post'))
		{
			$user = $this->Users->patchEntity($user, $this->request->data);

			if($this->Users->save($user))
			{
				$this->Flash->success('Thank you for registration, you can log in now');
				return $this->redirect(['action' => 'login']);

			}
			else
				$this->Flash->error('Registration not successful');

		}
		$this->set(compact('user'));
		$this->set('_serialize',['user']);

	}

	public function initialize()
	{
		parent::initialize();
                $session = $this->request->session();

		$this->Auth->allow(['logout']);
		$this->Auth->allow(['register', 'forgotpassword']);
        $this->Auth->allow(['admin']);//REM @author Aleksandr Anfilov. Allow  studierent/users/admin   w/o login.
	}

    /**
     * @author Muneeb Noor
     */
	public function logout()
	{
		$this->Flash->success('You are now logged out.');
		return $this->redirect($this->Auth->logout());
	}

    /**
     * Display User dashboard after login
     * @author Touhidur Rahman
     */
    public function dashboard(){
        $propertiesTbl = TableRegistry::get('properties');
        $favoritesTbl = TableRegistry::get('FavoriteProperties');
        $propertyCount = $propertiesTbl->find()->where(['user_id' => $this->Auth->user('id')])->count();
        $favCount = $favoritesTbl->find()->where(['user_id' => $this->Auth->user('id')])->count();
        $name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
        $id=$this->Auth->user('id');
        $this->set(compact('name', 'propertyCount', 'favCount', 'id'));

    }


    /**
     * Display Admin dashboard after login
     * @author Ramanpreet, 
     * @author Aleksandr Anfilov
     */
    public function admin(){
        /*@author Ramanpreet
        * In a controller or table method.
        * select type, count(*) from properties group by type
        */

        $connection = ConnectionManager::get('default');
        $results = $connection->execute('select count(id) as counts , type from properties group by type')->fetchAll('assoc');

        $this->set('results',$results);
        $users = $connection->execute('select count(id) as counts , status from users group by status')->fetchAll('assoc');
        //$users = $connection->execute('select count(id) as counts , status,roles from users left join roles on users.status=roles.id group by status')->fetchAll('assoc');
        $this->set('users', $users);

        /**
        * @author Aleksandr Anfilov
        * Display results of search by user id or name:
        */
        if($this->request->is('post'))
        {
            $form = $this->request->data();
            $searchBy = key($form);             // key: input name is 'id' or 'username'
            $searchParam = $form[$searchBy];    // get input value from array by key

//@source: Selecting Rows From A Table   http://book.cakephp.org/3.0/en/orm/query-builder.html
//@ERROR: Call to a member function find() on array $this-Users->find()->select(['id', 'first_name']);

            $searchQuery = TableRegistry::get('Users')
                ->find()                // 1. Prepare a SELECT query:
                ->select( ['id', 'last_name', 'first_name'] );
            
            switch ($searchBy) {        // 2. Add a WHERE condition
            case 'id':
                $searchQuery->where(['id' => $searchParam]);
            break;
                    
            case 'username':           //  find by username (which is an e-mail address)
                $searchQuery->where(['username' => $searchParam]);
            break;
            }

            $usersFound = $searchQuery->toArray();// 3. Execute the query
            
            if (!empty($usersFound)){
                $this->set('usersFound', $usersFound);
            }
            else{
                $this->Flash->error(__('No users have been found with the ' . $searchBy . ' ' . $searchParam . '.')); 
                }
        }
    }


    /**
     * Display Admin dashboard after login
     * @author Ramanpreet
     */
    public function forgotPassword($username = null)
    {
        if($this->request->is('post'))
        {
            $data= $this->request->data();

            $user = $this->Users->findByUsername($data['username']);
            //echo print_r($user);
            if (!($user->toArray()))
            {
                $this->Flash->error('User not found');
                $this->redirect(['controller' => 'users','action' => 'forgotpassword']);
            }
            else {
                $generated_password=substr(md5(rand(999,999999)) , 0 , 8);
               /* $data = $this->Users->password =  $generated_password;
                if ($this->Users->save($data)) {
                    $this->Flash->success('Password changed Succesfully.');
                     return $this->redirect(['controller' => 'Users','action' => 'login']);*/
                die($generated_password);

    }
        }
    }
    public function activation()  { }


    /*public function forgotPassword($username = null)
    {
    if($this->request->is('post')) {
         $username = $this->request->data['username'];
         $options = array('conditions' => array('User.' . $this->Users->username => $username));
         $found = $this->Users->find('first');


         if (!$username) {
             $this->Flash->error(__('No user with that email found.'));
             return $this->redirect(['controller' => 'Users','action' => 'forgotPassword']);

        }else{

                $random = 'a';
                $hasher = new DefaultPasswordHasher();
                $val = $hasher->hash($random);
                $data = $this->Users->password =  $val;
                if ($this->Users->save($data)) {
                    $this->Flash->success(__('Password changed Succesfully.'));
                     return $this->redirect(['controller' => 'Users','action' => 'forgotPassword']);
                }
            }
        }
    }*/

}