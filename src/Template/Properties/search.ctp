<div class="row">
    <!-- Filter Sidebar -->
    <div class="col-md-3 col-sm-4 col-xs-12">
        <div class="card bg-faded">
            <div class="card-block">
                <h4 class="card-title">Filters</h4>
                <p class="card-text">

                    <?= $this->Form->create(NULL, ['type' => 'get']); ?>

                        <fieldset class="form-group">
                            <label >Street or Zipcode</label>
                            <input type="text" class="form-control" name="address" placeholder="Marktstrasse or 36037">
                        </fieldset>

                        <label for="priceRange">Type</label>
                        <div class="checkbox">
                            <label style="display:block"><input type="radio" name="type" value="Flatshare" checked> Flatshare</label>
                            <label style="display:block"><input type="radio" name="type" value="Flat"> Flat</label>
                            <label style="display:block"><input type="radio" name="type" value="Student Residence"> Student Residence</label>
                            <label style="display:block"><input type="radio" name="type" value="House"> House</label>
                        </div>
                        <hr>

                        <div class="row">
                            <fieldset class="form-group col-sm-6">
                                <label for="">Min Rent</label>
                                <input type="text" class="form-control" id="" name="min" placeholder="EUR">
                            </fieldset>

                            <fieldset class="form-group col-sm-6">
                                <label for="">Max Rent</label>
                                <input type="text" class="form-control" id="" name="max" placeholder="EUR">
                            </fieldset>
                        </div>

                        <fieldset class="form-group">
                            <label for="" style="display:block" data-toggle="tooltip" data-placement="right" title="A score ranging 0-100 given by Studierent website to help you find the best match!">Studierent Score <i class="fa fa-question"></i></label>
                            <select class="form-control" id="" name="score">
                              <option value="0" checked>Select</option>
                              <option value="90">90+</option>
                              <option value="80">80+</option>
                              <option value="70">70+</option>
                              <option value="60">60+</option>
                              <option value="50">50+</option>
                              <option value="0">0+</option>
                          </select>
                        </fieldset>

                        <div class="radio">
                            <label for="">Distance from University</label>
                            <label style="display:block;"><input type="radio" name="dist" id="dist" value="2"> 0 - 2 km / 5 - 10 min walking</label>
                            <label style="display:block;"><input type="radio" name="dist" id="dist" value="5"> 2 - 5 km / 10 - 30 min walking</label>
                            <label style="display:block;"><input type="radio" name="dist" id="dist" value="100"> 5+ km / 30+ min walking</label>
                        </div>
                        <div class="checkbox">
                            <label style="display:block"><input name="directBus" type="checkbox" value="1"> Direct Bus to University</label>
                        </div>

                        <div id="accordion" role="tablist" aria-multiselectable="true">

                            <div class="card">
                                <div class="card-header" role="tab" id="headingOne">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="display:block">
                                  More
                                </a>
                                </div>
                                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="card-block">
                                        <!-- Available -->
                                        <div class="row">
                                            <fieldset class="form-group col-xs-12">
                                                <label for="">Available (From - To)</label>
                                            </fieldset>

                                            <fieldset class="form-group col-sm-6">
                                                <input type="text" name="avalFrom" class="form-control" id="fromDt" placeholder="yyyymmdd">
                                            </fieldset>

                                            <fieldset class="form-group col-sm-6">
                                                <input type="text" name="avalTo" class="form-control" id="toDt" placeholder="yyyymmdd">
                                            </fieldset>
                                        </div>
                                        <!-- Available fields end -->

                                        <!-- Sizes -->
                                        <div class="row">
                                            <fieldset class="form-group col-sm-6">
                                                <label for="">Room Size</label>
                                                <input type="text" name="rSize" class="form-control" id="" placeholder="">
                                            </fieldset>

                                            <fieldset class="form-group col-sm-6">
                                                <label for="">Flat Size</label>
                                                <input type="text" name="fSize" class="form-control" id="" placeholder="">
                                            </fieldset>
                                        </div>
                                        <!-- size fields end -->

                                        <!-- Amenities -->
                                        <label for="">Amenities</label>
                                        <div class="checkbox">
                                            <label style="display:block"><input type="checkbox" name="eBillIncl" value="1"> Electricity Bill Included</label>
                                            <label style="display:block"><input type="checkbox" name="internet" value="1"> Internet</label>
                                            <label style="display:block"><input type="checkbox" name="cableTv" value="1"> Cable TV</label>
                                            <label style="display:block"><input type="checkbox" name="wMachine" value="1"> Washing Machine</label>
                                            <label style="display:block"><input type="checkbox" name="fireAlarm" value="1"> Fire Alerm</label>
                                            <label style="display:block"><input type="checkbox" name="heating" value="1"> Heating</label>
                                            <label style="display:block"><input type="checkbox" name="parking" value="1"> Parking</label>
                                            <label style="display:block"><input type="checkbox" name="bikeParking" value="1"> Bike Parking</label>
                                            <label style="display:block"><input type="checkbox" name="garden" value="1"> Garden</label>
                                            <label style="display:block"><input type="checkbox" name="balcony" value="1"> Balcony</label>
                                            <label style="display:block"><input type="checkbox" name="smoking" value="1"> Smoking Allowed</label>
                                            <label style="display:block"><input type="checkbox" name="pets" value="1"> Pets Allowed</label>
                                        </div>
                                        <!-- Amenities end -->
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" role="tab" id="headingTwo">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="display:block">
                                  Landlord Rating
                                </a>
                                </div>
                                <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="card-block">
                                        <div class="checkbox">
                                            <label style="display:block"><input name="rating" value="5" type="checkbox">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </label>
                                            <label style="display:block"><input name="rating" value="4" type="checkbox">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </label>
                                            <label style="display:block"><input name="rating" value="3" type="checkbox">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </label>
                                            <label style="display:block"><input name="rating" value="2" type="checkbox">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </label>
                                            <label style="display:block"><input name="rating" value="1" type="checkbox">
                                                <i class="fa fa-star"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" role="tab" id="headingThree">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="display:block">
                                  Sort By
                                </a>
                                </div>
                                <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                                    <div class="card-block">
                                        <div class="radio">
                                            <label style="display:block;"><input type="radio" name="sortby" id="sortby" value="rentUp"> Rent (High - Low)</label>
                                            <label style="display:block;"><input type="radio" name="sortby" id="sortby" value="rentDown"> Rent (Low - High)</label>
                                            <label style="display:block;"><input type="radio" name="sortby" id="sortby" value="zipStreet"> Zipcode / Street</label>
                                            <label style="display:block;"><input type="radio" name="sortby" id="sortby" value="available_from_dt"> Available From Date</label>
                                            <label style="display:block;"><input type="radio" name="sortby" id="sortby" value="available_to_dt"> Available To Date</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">Submit</button>
                    <?= $this->Form->end(); ?>
                </p>
            </div>
        </div>
    </div>
    <!-- end sidebar -->

    <!-- Results -->
    <div class="col-md-9 col-sm-8 col-xs-12">

        <h1 class="display-4"><?= $count ?> Properties Found</h1>
        <?php foreach ($properties as $property){ ?>
            echo $this->element('adSnippet', ['property' => $property]);
        } ?>

    </div>
    <!-- end results -->

    <!-- pagination -->


</div>
</div>
