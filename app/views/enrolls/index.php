<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>

<section class="py-5 mt-5">
    <div class="container py-5">
        <div class="row">
            <div class="col mx-auto">
                <form id="enrollForm" action="#">
                    <div>
                        <h3>Qualify</h3>

                        <section>
                            <div class="form-group">
                                <label class="form-label">Email*</label>
                                <input id="email" name="email" class="form-control" type="text" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">Zip Code*</label>
                                <input id="zipcode" name="zipcode" class="form-control zipcode" type="text" maxlength="5" pattern="^[0-9]{5}$" placeholder="00000" />
                            </div>
                            <div class="form-group" id="checkmessage">

                            </div>
                        </section>

                        <h3>Personal Info</h3>

                        <section>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstname">First Name</label>
                                        <input type="text" id="firstname" name="firstname" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" id="lastname" name="lastname" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ssn">Last 4 digits of your Social Security Number</label>
                                        <input type="text" id="ssn" name="ssn" class="form-control" maxlength="4" pattern="[0-9]*" placeholder="0000">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dob">Birth Date</label>
                                        <div class="input-group">
                                            <input type="text" id="dobM" name="dobM" class="form-control" maxlength="2" pattern="[0-9]*" placeholder="MM">
                                            <input type="text" id="dobD" name="dobD" class="form-control" maxlength="2" pattern="[0-9]*" placeholder="DD">
                                            <input type="text" id="dobY" name="dobY" class="form-control" maxlength="4" pattern="[0-9]*" placeholder="YYYY">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email2">Email</label>
                                        <input type="text" id="email2" name="email2" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" id="phone" name="phone" class="form-control phoneUs">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row pt-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address1">Street Address</label>
                                        <input type="text" id="address1" name="address1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address2">Apartment or Unit Number</label>
                                        <input type="text" id="address2" name="addess2" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" id="city" name="city" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <select name="state" id="state" class="form-select">
                                            <option value="">Select a state</option>
                                            <option value="AL">Alabama</option>
                                            <option value="AK">Alaska</option>
                                            <option value="AZ">Arizona</option>
                                            <option value="AR">Arkansas</option>
                                            <option value="CA">California</option>
                                            <option value="CO">Colorado</option>
                                            <option value="CT">Connecticut</option>
                                            <option value="DE">Delaware</option>
                                            <option value="FL">Florida</option>
                                            <option value="GA">Georgia</option>
                                            <option value="HI">Hawaii</option>
                                            <option value="ID">Idaho</option>
                                            <option value="IL">Illinois</option>
                                            <option value="IN">Indiana</option>
                                            <option value="IA">Iowa</option>
                                            <option value="KS">Kansas</option>
                                            <option value="KY">Kentucky</option>
                                            <option value="LA">Louisiana</option>
                                            <option value="ME">Maine</option>
                                            <option value="MD">Maryland</option>
                                            <option value="MA">Massachusetts</option>
                                            <option value="MI">Michigan</option>
                                            <option value="MN">Minnesota</option>
                                            <option value="MS">Mississippi</option>
                                            <option value="MO">Missouri</option>
                                            <option value="MT">Montana</option>
                                            <option value="NE">Nebraska</option>
                                            <option value="NV">Nevada</option>
                                            <option value="NH">New Hampshire</option>
                                            <option value="NJ">New Jersey</option>
                                            <option value="NM">New Mexico</option>
                                            <option value="NY">New York</option>
                                            <option value="NC">North Carolina</option>
                                            <option value="ND">North Dakota</option>
                                            <option value="OH">Ohio</option>
                                            <option value="OK">Oklahoma</option>
                                            <option value="OR">Oregon</option>
                                            <option value="PA">Pennsylvania</option>
                                            <option value="RI">Rhode Island</option>
                                            <option value="SC">South Carolina</option>
                                            <option value="SD">South Dakota</option>
                                            <option value="TN">Tennessee</option>
                                            <option value="TX">Texas</option>
                                            <option value="UT">Utah</option>
                                            <option value="VT">Vermont</option>
                                            <option value="VA">Virginia</option>
                                            <option value="WA">Washington</option>
                                            <option value="WV">West Virginia</option>
                                            <option value="WI">Wisconsin</option>
                                            <option value="WY">Wyoming</option>
                                            <option value="DC">District of Columbia</option>
                                            <option value="PR">Puerto Rico</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="zipcode2">Zipcode</label>
                                        <input type="text" id="zipcode2" name="zipcode2" class="form-control zipcode" maxlength="5" pattern="^[0-9]{5}$" placeholder="00000">
                                    </div>
                                </div>
                                <div class="col-md-12 pt-2">
                                    <h6>is this address permanent or temporary?</h6>
                                    <div class="form-check">

                                        <input type="radio" name="typeAddress" id="typeAddres1" class="form-check-input" value="Permanent">
                                        <label class="form-chack-label" for="typeAddress1">Permanent</label>
                                    </div>
                                    <div class="form-check">

                                        <input type="radio" name="typeAddress" id="typeAddres2" class="form-check-input" value="Temporary">
                                        <label class="form-chack-label" for="typeAddress2">Temporary</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 pt-2" id="showShip" style="cursor:pointer">
                                    <h6>Ship to a different address? <i class="fa fa-chevron-down"></i></h6>
                                </div>
                            </div>
                            <div id="shipArea" style="display:none;">
                                <div class="row pt-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="shipaddress1">Street Address</label>
                                            <input type="text" id="shipaddress1" name="shipaddress1" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="shipaddress2">Apartment or Unit Number</label>
                                            <input type="text" id="shipaddress2" name="shipaddess2" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="shipcity">City</label>
                                            <input type="text" id="shipcity" name="shipcity" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="shipstate">State</label>
                                            <select name="shipstate" id="shipstate" class="form-select">
                                                <option value="">Select a state</option>
                                                <option value="AL">Alabama</option>
                                                <option value="AK">Alaska</option>
                                                <option value="AZ">Arizona</option>
                                                <option value="AR">Arkansas</option>
                                                <option value="CA">California</option>
                                                <option value="CO">Colorado</option>
                                                <option value="CT">Connecticut</option>
                                                <option value="DE">Delaware</option>
                                                <option value="FL">Florida</option>
                                                <option value="GA">Georgia</option>
                                                <option value="HI">Hawaii</option>
                                                <option value="ID">Idaho</option>
                                                <option value="IL">Illinois</option>
                                                <option value="IN">Indiana</option>
                                                <option value="IA">Iowa</option>
                                                <option value="KS">Kansas</option>
                                                <option value="KY">Kentucky</option>
                                                <option value="LA">Louisiana</option>
                                                <option value="ME">Maine</option>
                                                <option value="MD">Maryland</option>
                                                <option value="MA">Massachusetts</option>
                                                <option value="MI">Michigan</option>
                                                <option value="MN">Minnesota</option>
                                                <option value="MS">Mississippi</option>
                                                <option value="MO">Missouri</option>
                                                <option value="MT">Montana</option>
                                                <option value="NE">Nebraska</option>
                                                <option value="NV">Nevada</option>
                                                <option value="NH">New Hampshire</option>
                                                <option value="NJ">New Jersey</option>
                                                <option value="NM">New Mexico</option>
                                                <option value="NY">New York</option>
                                                <option value="NC">North Carolina</option>
                                                <option value="ND">North Dakota</option>
                                                <option value="OH">Ohio</option>
                                                <option value="OK">Oklahoma</option>
                                                <option value="OR">Oregon</option>
                                                <option value="PA">Pennsylvania</option>
                                                <option value="RI">Rhode Island</option>
                                                <option value="SC">South Carolina</option>
                                                <option value="SD">South Dakota</option>
                                                <option value="TN">Tennessee</option>
                                                <option value="TX">Texas</option>
                                                <option value="UT">Utah</option>
                                                <option value="VT">Vermont</option>
                                                <option value="VA">Virginia</option>
                                                <option value="WA">Washington</option>
                                                <option value="WV">West Virginia</option>
                                                <option value="WI">Wisconsin</option>
                                                <option value="WY">Wyoming</option>
                                                <option value="DC">District of Columbia</option>
                                                <option value="PR">Puerto Rico</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="shipzipcode">Zipcode</label>
                                            <input type="text" id="shipzipcode" name="shipzipcode" class="form-control zipcode" maxlength="5" pattern="^[0-9]{5}$" placeholder="00000">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </section>

                        <h3>Elegibility</h3>

                        <section>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="eligibility_program">Select Government Program</label>
                                        <select name="eligibility_program" id="eligibility_program" class="form-control form-control-lg">

                                            <option value="">Select..</option>

                                            <option value="100001">Supplemental Nutrition Assistance Program (Food Stamps or SNAP)</option>

                                            <option value="100004">Medicaid</option>

                                            <option value="100002">Household Income</option>

                                            <option value="100006">Supplemental Security Income (SSI)</option>

                                            <option value="100000">Federal Public Housing Assistance (Section 8)</option>

                                            <option value="100014">Veteran’s Pension or Survivors Benefit Programs</option>

                                            <option value="100011">Bureau of Indian Affairs General Assistance</option>

                                            <option value="100008">Tribally-Administered Temporary Assistance for Needy Families (TTANF)</option>

                                            <option value="100010">Food Distribution Program on Indian Reservations (FDPIR)</option>

                                            <option value="100009">Head Start (if income eligibility criteria are met)</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h6>Are you a Current Recipient of Lifeline Benefits?</h6>
                                        <div class="form-check form-check-inline">
                                            <input class=" form-check-input" value="Yes" type="radio" name="current_benefits" id="current_benefits1">

                                            <label class="form-check-label" for="current_benefits1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">

                                            <input class=" form-check-input" value="No" type="radio" name="current_benefits" id="current_benefits2">

                                            <label class="form-check-label" for="current_benefits2">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nv_application_id">National Verifier Application ID</label>
                                        <input type="text" id="nv_application_id" name="nv_application_id" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h6>What type of phone do you currently use?</h6>
                                        <div class="form-check form-check-inline">
                                            <input class=" form-check-input" value="Yes" type="radio" name="type_phone" id="apple_phone">

                                            <label class="form-check-label" for="apple_phone"> <i class="fa fa-apple" style="color:darkgrey"></i> iOS</label>
                                        </div>
                                        <div class="form-check form-check-inline">

                                            <input class=" form-check-input" value="No" type="radio" name="type_phone" id="android_phone">

                                            <label class="form-check-label" for="android_phone"> <i class="fa fa-android" style="color:green"></i> Android</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h3>Agreement</h3>

                        <section>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <p style="margin-bottom: 0;">I agree, under penalty of perjury,to the following statements:</p>
                                        <p><small>(You must initial next to each statement.)</small></p>
                                        <div class="row">
                                            <div class="col-2">
                                                <input class="form-control" name="initial_1" onclick="updateInitials('initial_1')" type="text" maxlength="2" id="initial_1" data-gtm-form-interact-field-id="1">
                                                <small>Initial</small>
                                            </div>
                                            <div class="col-10">
                                                <p> I (or my dependent or other person in my household) currently get benefits from the government

                                                    program(s) listed on this form or my annual household income is 135% or less than the Federal

                                                    Poverty Guidelines (the amount listed in the Federal Poverty Guidelines table on this form).</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2">
                                                <input class="form-control" name="initial_2" onclick="updateInitials('initial_2')" type="text" maxlength="2" id="initial_2" style="display: block !important" data-gtm-form-interact-field-id="2">
                                                <small>Initial</small>
                                            </div>
                                            <div class="col-10">
                                                <p>I agree that if I move I will give my service provider my new address within 30&nbsp;days.</p>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-2">

                                                <input class="form-control" name="initial_3" onclick="updateInitials('initial_3')" type="text" maxlength="2" id="initial_3" data-gtm-form-interact-field-id="3" aria-invalid="false">

                                                <small>Initial</small>

                                            </div>

                                            <div class="col-10">
                                                I understand that I have to tell my service provider within 30 days if I do not qualify for Lifeline

                                                anymore,&nbsp;including:<br>

                                                1.) I, or the person in my household that qualifies, do not qualify through a government

                                                program or income&nbsp;anymore.<br>

                                                2.) Either I or someone in my household gets more than one Lifeline benefit (including more

                                                than one Lifeline broadband internet service, more than one Lifeline telephone service, or

                                                both Lifeline telephone and Lifeline broadband internet&nbsp;services).
                                            </div>

                                        </div>
                                        <div class="row">

                                            <div class="col-2">

                                                <input class="form-control" name="initial_4" onclick="updateInitials('initial_4')" type="text" maxlength="2" id="initial_4">

                                                <small>Initial</small>

                                            </div>

                                            <div class="col-10">
                                                <p>I know that my household can only get one Lifeline benefit and, to the best of my knowledge,

                                                    my household is not getting more than one Lifeline&nbsp;benefit.</p>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-2">

                                                <input class="form-control" name="initial_5" onclick="updateInitials('initial_5')" type="text" maxlength="2" id="initial_5" aria-invalid="false">

                                                <small>Initial</small>

                                            </div>

                                            <div class="col-10">

                                                <p>I agree that all of the information I provide on this form may be collected, used, shared, and retained

                                                    for the purposes of applying for and/or receiving the Lifeline Program benefit. I understand that

                                                    if this information is not provided to the Lifeline Program Administrator, I will not be able to get

                                                    Lifeline benefits. If the laws of my state or Tribal government require it, I agree that the state or

                                                    Tribal government may share information about my benefits for a qualifying program with the

                                                    Lifeline Program Administrator. The information shared by the state or Tribal government will be

                                                    used only to help find out if I can get a Lifeline Program&nbsp;benefit.</p>
                                            </div>

                                        </div>

                                        <!-- <li class="list-group-item pb-0 pt-3">

                                            <div class="grid-row form-text pb-0">

                                                <div class="grid-item">

                                                    <input class="form-initial_input mr-2 valid" name="initial_6" onclick="updateInitials('initial_6')" type="text" maxlength="2" id="initial_6" style="display: block !important">

                                                    <small>Initial</small>

                                                </div>

                                                <label class="form-check-label" for="initial_6">

                                                    All the answers and agreements that I provided on this form are true and correct to the best

                                                    of my&nbsp;knowledge.</label>

                                            </div>

                                            <div><label id="initial_6-error" class="error" for="initial_6" style="display: none;"></label></div>

                                        </li>

                                        <li class="list-group-item pb-0 pt-3">

                                            <div class="grid-row form-text pb-0">

                                                <div class="grid-item">

                                                    <input class="form-initial_input mr-2 valid" name="initial_7" onclick="updateInitials('initial_7')" type="text" maxlength="2" id="initial_7">

                                                    <small>Initial</small>

                                                </div>

                                                <label class="form-check-label" for="initial_7">

                                                    I know that willingly giving false or fraudulent information to get Lifeline Program benefits is

                                                    punishable by law and can result in fines, jail time, de-enrollment, or being barred from the&nbsp;program.</label>

                                            </div>

                                            <div><label id="initial_7-error" class="error" for="initial_7" style="display: none;"></label></div>

                                        </li>

                                        <li class="list-group-item pb-0 pt-3">

                                            <div class="grid-row form-text pb-0">

                                                <div class="grid-item">

                                                    <input class="form-initial_input mr-2 valid" name="initial_8" onclick="updateInitials('initial_8')" type="text" maxlength="2" id="initial_8">

                                                    <small>Initial</small>

                                                </div>

                                                <label class="form-check-label" for="initial_8">

                                                    My service provider may have to check whether I still qualify at any time. If I need to recertify

                                                    (renew) my Lifeline benefit, I understand that I have to respond by the deadline or I will be

                                                    removed from the Lifeline Program and my Lifeline benefit will&nbsp;stop.</label>

                                            </div>

                                            <div><label id="initial_8-error" class="error" for="initial_8" style="display: none;"></label></div>

                                        </li>

                                        <li class="list-group-item pb-0 pt-3 ">

                                            <div class="grid-row form-text pb-0">

                                                <div class="grid-item">

                                                    <input class="form-initial_input mr-2 valid" name="initial_9" onclick="updateInitials('initial_9')" type="text" maxlength="2" id="initial_9" aria-invalid="false">

                                                    <small>Initial</small>

                                                </div>

                                                <label class="form-check-label" for="initial_9">

                                                    The certification below applies to all consumers and is required to process your application.

                                                    I was truthful about whether or not I am a resident of Tribal lands, as defined in section 2 of

                                                    this&nbsp;form</label>

                                            </div>

                                            <div><label id="initial_9-error" class="error" for="initial_9" style="display: none;"></label></div>

                                        </li>

                                    </ul> -->
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require APPROOT . '/views/inc/footer.php'; ?>

<script>
    $(document).ready(function() {
        $(".phoneUs").mask('(000) 000-0000');
        $(".zipcode").mask('00000')
    });
    var form = $("#enrollForm");
    form.validate({
        errorPlacement: function errorPlacement(error, element) {
            element.before(error);
        },
        rules: {
            zipcode: {
                required: true,
                zipcodeUS: true
            },
            email: {
                required: true,
                email: true
            }
        }
    });
    form.children("div").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onStepChanging: function(event, currentIndex, newIndex) {
            form.validate().settings.ignore = ":disabled,:hidden";
            console.log(currentIndex)

            if (form.valid() === true) {
                var canProceed = false;
                // Optional: You can use `async: false` to force blocking until AJAX completes
                if (currentIndex === 0) {
                    var customerEmail = $("#email").val();
                    var zipcode = $("#zipcode").val()


                    $.ajax({
                        url: "<?php echo URLROOT; ?>/enrolls/check",
                        method: "POST",
                        data: {
                            "email": customerEmail,
                            "zipcode": zipcode
                        },
                        async: false, // block navigation until response
                        success: function(response) {
                            console.log("Step " + currentIndex + " saved.");
                            console.log(response);
                            var myObj = JSON.parse(response)
                            if (myObj.status == "fail") {
                                canProceed = false;
                                $("#checkmessage").html("<p style='color:red'>Sorry!, Unfortunatelly we can't provide services for this zipcode area, but we will email you when our service it's available on you area</p>")
                            } else {
                                canProceed = true;
                                $("#email2").val(customerEmail).attr('disabled', 'disabled')
                                $("#zipcode2").val(zipcode).attr('disabled', 'disabled')
                            }


                        },
                        error: function() {
                            alert("Error saving step " + currentIndex);
                        }
                    });
                } else if (currentIndex === 1) {
                    canProceed = true;
                } else if (currentIndex === 2) {
                    canProceed = true;
                }
            }
            return canProceed;
            //return form.valid();
        },
        onFinishing: function(event, currentIndex) {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function(event, currentIndex) {
            alert("Submitted!");
        }
    });

    // $('.zipcode').on('blur', function () {
    //   let val = $(this).val().trim();
    //   if (/^\d{4}$/.test(val)) {
    //     $(this).val(val.padStart(5, '0'));
    //   }
    // });

    $('#showShip').on('click', function() {
        $('#shipArea').toggle(); // Or use slideToggle() for animation

        const isVisible = $('#shipArea').is(':visible');
        $(this).html(isVisible ?
            '<h6>Ship to a different address? <i class="fa fa-chevron-up"></i></h6>' :
            '<h6>Ship to a different address? <i class="fa fa-chevron-down"></i></h6>');
    });
</script>