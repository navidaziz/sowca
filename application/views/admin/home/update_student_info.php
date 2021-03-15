<div class="modal-body">

        <div class="box-body">

        <?php
                $edit_form_attr = array("class" => "form-hor izontal");
                echo form_open_multipart(ADMIN_DIR."home/update_student_info_data/", $edit_form_attr);
            ?>
            <?php echo form_hidden("student_id", $student->student_id); ?>
            <div class="col-md-6">
                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('student_name'), "student_name", $label);      ?>


                    <?php

                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "student_name",
                        "id"            =>  "student_name",
                        "class"         =>  "form-control",
                        "style"         =>  "", "required"	  => "required",
                        "title"         =>  $this->lang->line('student_name'),
                        "value"         =>  set_value("student_name", $student->student_name),
                        "placeholder"   =>  $this->lang->line('student_name'),
                        
                    );
                    echo  form_input($text);
                    ?>
                    <?php echo form_error("student_name", "<p class=\"text-danger\">", "</p>"); ?>


                </div>

            </div>
            <div class="col-md-6">

                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('father_name'), "father_name", $label);      ?>

                    <?php

                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "father_name",
                        "id"            =>  "father_name",
                        "class"         =>  "form-control",
                        "style"         =>  "", "required"	  => "required", "title"         =>  $this->lang->line('father_name'),
                        "value"         =>  set_value("father_name", $student->father_name),
                        "placeholder"   =>  $this->lang->line('father_name')
                    );
                    echo  form_input($text);
                    ?>
                    <?php echo form_error("father_name", "<p class=\"text-danger\">", "</p>"); ?>

                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <?php
                    $label = array(
                        "class" => "control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('gender'), "gender", $label);
                    ?>
                    <br />
                    <?php
                    $options = array("male" => "Male", "female" => "Female");
                    foreach ($options as $option_value => $options_name) {

                        $data = array(
                            "name"        => "gender",
                            "id"          => "gender",
                            "value"       => $option_value,
                            "style"       => "", "required"	  => "required",
                            "class"       => "uniform"
                        );
                        if($option_value == $student->gender){
                            $data["checked"] = TRUE;
                        }
                        echo form_radio($data) . "<label for=\"gender\" style=\"margin-left:10px;\">$options_name</label>   ";
                    }
                    ?>
                    <?php echo form_error("gender", "<p class=\"text-danger\">", "</p>"); ?>
                </div>

            </div>


            <div class="col-md-8">
                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('address'), "address", $label);      ?>


                    <?php

                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "address",
                        "id"            =>  "address",
                        "class"         =>  "form-control",
                        "style"         =>  "", "required"	  => "required", "title"         =>  $this->lang->line('address'),
                        "value"         =>  set_value("address", $student->address),
                        "placeholder"   =>  $this->lang->line('address')
                    );
                    echo  form_input($text);
                    ?>
                    <?php echo form_error("address", "<p class=\"text-danger\">", "</p>"); ?>
                </div>

            </div>




            <div class="col-md-6">

                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('mobile_no'), "mobile_no", $label);      ?>


                    <?php

                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "mobile_no",
                        "id"            =>  "mobile_no",
                        "class"         =>  "form-control",
                        "style"         =>  "", "required"	  => "required", "title"         =>  $this->lang->line('mobile_no'),
                        "value"         =>  set_value("mobile_no", $student->mobile_no),
                        "placeholder"   =>  $this->lang->line('mobile_no')
                    );
                    echo  form_input($text);
                    ?>
                    <?php echo form_error("mobile_no", "<p class=\"text-danger\">", "</p>"); ?>
                </div>



            </div>
            <div class="col-md-6">
                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('phone_no'), "phone_no", $label);      ?>


                    <?php

                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "phone_no",
                        "id"            =>  "phone_no",
                        "class"         =>  "form-control",
                        "style"         =>  "", "required"	  => "required",
                        "title"         =>  $this->lang->line('phone_no'),
                        "value"         =>  set_value("phone_no", $student->phone_no),
                        "placeholder"   =>  $this->lang->line('phone_no')
                    );
                    echo  form_input($text);
                    ?>
                    <?php echo form_error("phone_no", "<p class=\"text-danger\">", "</p>"); ?>
                </div>



            </div>

            <div class="col-md-6">

                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('class'), "class", $label);      ?>


                    <?php

                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "class",
                        "id"            =>  "class",
                        "class"         =>  "form-control",
                        "style"         =>  "", "required"	  => "required", "title"         =>  $this->lang->line('class'),
                        "value"         =>  set_value("class", $student->class),
                        "placeholder"   =>  $this->lang->line('class')
                    );
                    echo  form_input($text);
                    ?>
                    <?php echo form_error("class", "<p class=\"text-danger\">", "</p>"); ?>
                </div>



            </div>
            <div class="col-md-6">
                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('institute'), "institute", $label);      ?>


                    <?php

                    $text = array(
                        "type"          =>  "text",
                        "name"          =>  "institute",
                        "id"            =>  "institute",
                        "class"         =>  "form-control",
                        "style"         =>  "", "required"	  => "required", "title"         =>  $this->lang->line('institute'),
                        "value"         =>  set_value("institute", $student->institute),
                        "placeholder"   =>  $this->lang->line('institute')
                    );
                    echo  form_input($text);
                    ?>
                    <?php echo form_error("institute", "<p class=\"text-danger\">", "</p>"); ?>
                </div>



            </div>
            <!-- <div class="col-md-4">
                <div class="form-group">
                    <?php
                    $label = array(
                        "class" => "control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('on_scholarship'), "on_scholarship", $label);
                    ?>

                <br />
                        <?php
                        $options = array("Yes" => "Yes", "No" => "No");
                        foreach ($options as $option_value => $options_name) {

                            $data = array(
                                "name"        => "on_scholarship",
                                "id"          => "on_scholarship",
                                "value"       => $option_value,
                                "style"       => "", "required"	  => "required",
                                "class"       => "uniform"
                            );
                            echo form_radio($data) . "<label for=\"on_scholarship\" style=\"margin-left:10px;\">$options_name</label>";
                        }
                        ?>
                        <?php echo form_error("on_scholarship", "<p class=\"text-danger\">", "</p>"); ?>
                    </div>
                </div> -->
            <!-- <div class="col-md-4">

                <div class="form-group">
                    <?php
                    $label = array(
                        "class" => "control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('scholarship_name'), "Scholarship Id", $label);
                    ?>

                    <?php
                    echo form_dropdown("scholarship_id", $scholarships, "", "class=\"form-control\" required style=\"\"");
                    ?>
                </div>
                <?php echo form_error("scholarship_id", "<p class=\"text-danger\">", "</p>"); ?>
            </div> -->
            <input type="hidden" name="scholarship_id" value="1" />
            <input type="hidden" name="transport" value="No" />
            <!--<div class="col-md-4">



                <div class="form-group">
                    <?php
                    $label = array(
                        "class" => "control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('transport'), "transport", $label);
                    ?>

                    <br />
                        <?php
                        $options = array("Yes" => "Yes", "No" => "No");
                        foreach ($options as $option_value => $options_name) {

                            $data = array(
                                "name"        => "transport",
                                "id"          => "transport",
                                "value"       => $option_value,
                                "style"       => "", "required"	  => "required",
                                "class"       => "uniform"
                            );
                            echo form_radio($data) . "<label for=\"transport\" style=\"margin-left:10px;\">$options_name</label> ";
                        }
                        ?>
                        <?php echo form_error("transport", "<p class=\"text-danger\">", "</p>"); ?>
                    </div>
                </div> -->


            <div class="col-md-8">
                <br />
                <?php
                $submit = array(
                    "type"  =>  "submit",
                    "name"  =>  "submit",
                    "value" =>  "Save Student Informaiton",
                    "class" =>  "btn btn-primary pull-right",
                    "style" =>  ""
                );
                echo form_submit($submit);
                ?>

            </div>
            <div style="clear:both;"></div>

            <?php echo form_close(); ?>

        </div>


    </div>