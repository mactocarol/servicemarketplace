<!-- /.content-wrapper -->

  <footer class="main-footer">

    

    <strong>Copyright &copy; 2019  <a href="#">servicemarketplace.com</a>.</strong> All rights

    reserved.

  </footer>



</div>

<!-- ./wrapper -->

 

<script src="<?php echo base_url();?>/assets/bootstrapValidator.min.js"></script>

<!-- Select2 -->

<script src="<?php echo base_url();?>/assets/bower_components/select2/dist/js/select2.full.min.js"></script>



  <?php if($field == 'Datepicker'){ ?>			

			<!-- InputMask -->

			<script src="<?php echo base_url();?>/assets/plugins/input-mask/jquery.inputmask.js"></script>

			<script src="<?php echo base_url();?>/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>

			<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>

			<!-- date-range-picker -->

			<script src="<?php echo base_url();?>/assets/bower_components/moment/min/moment.min.js"></script>

			<script src="<?php echo base_url();?>/assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

			<!-- bootstrap datepicker -->

			<script src="<?php echo base_url();?>/assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

			<!-- bootstrap time picker -->

			<script src="<?php echo base_url();?>/assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>

			<!-- SlimScroll -->

			<script src="<?php echo base_url();?>/assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

			<!-- iCheck 1.0.1 -->

			<script src="<?php echo base_url();?>/assets/plugins/iCheck/icheck.min.js"></script>

			<!-- Page script -->

			<script>

			  $(function () {

				//Datemask dd/mm/yyyy

				$('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });

				//Datemask2 mm/dd/yyyy

				$('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' });

				//Money Euro

				$('[data-mask]').inputmask();

			

				//Date range picker

				$('#reservation').daterangepicker();

				//Date range picker with time picker

				$('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' });

				//Date range as a button

				$('#daterange-btn').daterangepicker(

				  {

					ranges   : {

					  'Today'       : [moment(), moment()],

					  'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],

					  'Last 7 Days' : [moment().subtract(6, 'days'), moment()],

					  'Last 30 Days': [moment().subtract(29, 'days'), moment()],

					  'This Month'  : [moment().startOf('month'), moment().endOf('month')],

					  'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]

					},

					startDate: moment().subtract(29, 'days'),

					endDate  : moment()

				  },

				  function (start, end) {

					$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

				  }

				);

			

				//Date picker

				$('#datepicker').datepicker({

				  autoclose: true

				});

			

				//iCheck for checkbox and radio inputs

				$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({

				  checkboxClass: 'icheckbox_minimal-blue',

				  radioClass   : 'iradio_minimal-blue'

				});

				//Red color scheme for iCheck

				$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({

				  checkboxClass: 'icheckbox_minimal-red',

				  radioClass   : 'iradio_minimal-red'

				});

				//Flat red color scheme for iCheck

				$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({

				  checkboxClass: 'icheckbox_flat-green',

				  radioClass   : 'iradio_flat-green'

				});

			

			

			

				//Timepicker

				$('.timepicker').timepicker({

				  showInputs: false

				});

			  });

			</script>

  <?php } ?>

  <?php if($field == 'Datatable'){ ?>			

			<!-- DataTables -->

			<script src="<?php echo base_url();?>/assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>

			<script src="<?php echo base_url();?>/assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

			<!-- page script -->

			<script>

			  $(function () {

				$('#dataTable').DataTable();

				//$('#example2').DataTable({

				//  'paging'      : true,

				//  'lengthChange': false,

				//  'searching'   : true,

				//  'ordering'    : true,

				//  'info'        : true,

				//  'autoWidth'   : false

				//});

				$('#dataTable1').DataTable();

			  });

             

			</script>

			<script>

			$(document).ready(function() {

				$('#dataTable_').DataTable( {

					"ajax": {

						"url": '<?php echo site_url('admin/list_user1');?>',

						"dataSrc": ""        

					},

					"columns": [

						{ "data": "id" },

						{ "data": "username" },

						// { "data": "email" }

					]

				} );

			} );

			</script>

  <?php } ?>

<!-- AdminLTE App -->

<script src="<?php echo base_url();?>/assets/dist/js/adminlte.min.js"></script>

<!-- Page script -->

<script>

  $(function () {

    //Initialize Select2 Elements

    $('.select2').select2();

  });

</script>



<script>

    

    $(document).ready(function() {

        setTimeout(function(){ $("#alert").css("display","none");}, 3000);

	//alert('http://localhost/caroldata.com/hmvc_hotel_booking/registration/register_email_exists');

    $('#add_user_form').bootstrapValidator({

        //container: '#messages',

        feedbackIcons: {

            valid: 'glyphicon glyphicon-ok',

            invalid: 'glyphicon glyphicon-remove',

            validating: 'glyphicon glyphicon-refresh'

        },

        fields: {

            username: {

                validators: {

					notEmpty: {

						message : 'The Username Field is required and cannot be empty '

					},

					 remote: {  

					 type: 'POST',

					 url: "<?php echo site_url();?>user/check_username_exists",

					 data: function(validator) {

						 return {

							 //email: $('#email').val()

							 email: validator.getFieldElements('username').val()

							 };

						},

					 message: 'This Username is already in use.'     

					 }

				},

			}, 

			contact: {

                validators: {

                    notEmpty: {

                        message: 'The Contact is required and cannot be empty'

                    },

                }

            },

            category: {

                validators: {

                    notEmpty: {

                        message: 'The Category is required and cannot be empty'

                    },

                }

            },            

			// email: {

   //              validators: {

			// 		notEmpty: {

			// 			message : 'The email Field is required and cannot be empty '

			// 		},

			// 		 remote: {  

			// 		 type: 'POST',

			// 		 url: "<?php echo site_url();?>user/check_email_exists",

			// 		 data: function(validator) {

			// 			 return {

			// 				 //email: $('#email').val()

			// 				 email: validator.getFieldElements('email').val()

			// 				 };

			// 			},

			// 		 message: 'This email is already in use.'     

			// 		 }

			// 	},

			// },    

			

			password: {

				validators: {

                    notEmpty: {

						message : 'The password Field is required and cannot be empty '

					},

					identical: {

                        field: 'repassword',

                        message: 'The password and its confirm are not the same'

                    },

					stringLength: {

						min: 6 ,

						max: 15,

						message: 'The password length min 6 and max 15 character Long'

					}

				}

			},

			repassword: {

				validators: {

                    notEmpty: {

						message : 'The password Field is required and cannot be empty '

					},

					identical: {

                        field: 'password',

                        message: 'The password and its confirm are not the same'

                    }

					

				}

			},

        }

    });

    

    $('#edit_user_form').bootstrapValidator({

        //container: '#messages',

        feedbackIcons: {

            valid: 'glyphicon glyphicon-ok',

            invalid: 'glyphicon glyphicon-remove',

            validating: 'glyphicon glyphicon-refresh'

        },

        fields: {

            username: {

                validators: {

					notEmpty: {

						message : 'The Username Field is required and cannot be empty '

					},

					 remote: {  

					 type: 'POST',

					 url: "<?php echo site_url();?>admin/check_username_exists/<?php echo $this->uri->segment(3);?>",

					 data: function(validator) {

						 return {

							 //email: $('#email').val()

							 email: validator.getFieldElements('username').val()

							 };

						},

					 message: 'This Username is already in use.'     

					 }

				},

			},

			contact: {

                validators: {

                    notEmpty: {

                        message: 'The Contact is required and cannot be empty'

                    },

                }

            },

            category: {

                validators: {

                    notEmpty: {

                        message: 'The Category is required and cannot be empty'

                    },

                }

            },            

			// email: {

   //              validators: {

			// 		notEmpty: {

			// 			message : 'The email Field is required and cannot be empty '

			// 		},

			// 		 remote: {  

			// 		 type: 'POST',

			// 		 url: "<?php echo site_url();?>admin/check_email_exists/<?php echo $this->uri->segment(3);?>",

			// 		 data: function(validator) {

			// 			 return {

			// 				 //email: $('#email').val()

			// 				 email: validator.getFieldElements('email').val()

			// 				 };

			// 			},

			// 		 message: 'This email is already in use.'     

			// 		 }

			// 	},

			// },    

			

			password: {

				validators: {                    

					identical: {

                        field: 'repassword',

                        message: 'The password and its confirm are not the same'

                    },

					stringLength: {

						min: 6 ,

						max: 15,

						message: 'The password length min 6 and max 15 character Long'

					}

				}

			},

			repassword: {

				validators: {                    

					identical: {

                        field: 'password',

                        message: 'The password and its confirm are not the same'

                    }

					

				}

			},

        }

    });

    

    $('#plan_form').bootstrapValidator({

        //container: '#messages',

        feedbackIcons: {

            valid: 'glyphicon glyphicon-ok',

            invalid: 'glyphicon glyphicon-remove',

            validating: 'glyphicon glyphicon-refresh'

        },

        fields: {

             

			title: {

                validators: {

                    notEmpty: {

                        message: 'The Plan is required and cannot be empty'

                    },

                }

            },

            amount: {

                validators: {

                    notEmpty: {

                        message: 'The amount is required and cannot be empty'

                    },

                }

            },

            validity: {

                validators: {

                    notEmpty: {

                        message: 'The plan valdity is required and cannot be empty'

                    },

                }

            },

            pic_limit: {

                validators: {

                    notEmpty: {

                        message: 'The picture limit is required and cannot be empty'

                    },

                }

            },

            audio_limit: {

                validators: {

                    notEmpty: {

                        message: 'The audio limit is required and cannot be empty'

                    },

                }

            },

            video_limit: {

                validators: {

                    notEmpty: {

                        message: 'The video limit is required and cannot be empty'

                    },

                }

            },

            sell_limit: {

                validators: {

                    notEmpty: {

                        message: 'The product sell limit is required and cannot be empty'

                    },

                }

            },

			

        }

    });

    

    $('#edit_entrepreneur_form').bootstrapValidator({

        //container: '#messages',

        feedbackIcons: {

            valid: 'glyphicon glyphicon-ok',

            invalid: 'glyphicon glyphicon-remove',

            validating: 'glyphicon glyphicon-refresh'

        },

        fields: {

            username: {

                validators: {

					notEmpty: {

						message : 'The Username Field is required and cannot be empty '

					},

					 remote: {  

					 type: 'POST',

					 url: "<?php echo site_url();?>admin/check_username_exists/<?php echo $this->uri->segment(3);?>",

					 data: function(validator) {

						 return {

							 //email: $('#email').val()

							 email: validator.getFieldElements('username').val()

							 };

						},

					 message: 'This Username is already in use.'     

					 }

				},

			},

			contact: {

                validators: {

                    notEmpty: {

                        message: 'The Contact is required and cannot be empty'

                    },

                }

            },

            category: {

                validators: {

                    notEmpty: {

                        message: 'The Category is required and cannot be empty'

                    },

                }

            },

            companyname: {

                validators: {

                    notEmpty: {

                        message: 'The company name is required and cannot be empty'

                    },

                }

            },

			// email: {

   //              validators: {

			// 		notEmpty: {

			// 			message : 'The email Field is required and cannot be empty '

			// 		},

			// 		 remote: {  

			// 		 type: 'POST',

			// 		 url: "<?php echo site_url();?>admin/check_email_exists/<?php echo $this->uri->segment(3);?>",

			// 		 data: function(validator) {

			// 			 return {

			// 				 //email: $('#email').val()

			// 				 email: validator.getFieldElements('email').val()

			// 				 };

			// 			},

			// 		 message: 'This email is already in use.'     

			// 		 }

			// 	},

			// },    

			

			password: {

				validators: {                    

					identical: {

                        field: 'repassword',

                        message: 'The password and its confirm are not the same'

                    },

					stringLength: {

						min: 6 ,

						max: 15,

						message: 'The password length min 6 and max 15 character Long'

					}

				}

			},

			repassword: {

				validators: {                    

					identical: {

                        field: 'password',

                        message: 'The password and its confirm are not the same'

                    }

					

				}

			},

        }

    });

    

    $('#profile_update_form').bootstrapValidator({

        //container: '#messages',

        feedbackIcons: {

            valid: 'glyphicon glyphicon-ok',

            invalid: 'glyphicon glyphicon-remove',

            validating: 'glyphicon glyphicon-refresh'

        },

        fields: {

            f_name: {

                validators: {

                    notEmpty: {

                        message: 'The First name is required and cannot be empty'

                    },

                }

            },

			l_name: {

                validators: {

                    notEmpty: {

                        message: 'The Last name is required and cannot be empty'

                    },

                }

            },

                       

			// email: {

   //              validators: {

			// 		notEmpty: {

			// 			message : 'The email Field is required and cannot be empty '

			// 		},

			// 		 remote: {  

			// 		 type: 'POST',

			// 		 url: "<?php echo site_url();?>user/check_email_exists1",

			// 		 data: function(validator) {

			// 			 return {

			// 				 //email: $('#email').val()

			// 				 email: validator.getFieldElements('email').val()

			// 				 };

			// 			},

			// 		 message: 'This email is already in use.'     

			// 		 }

			// 	},

			// },    

			

			password: {

				validators: {                    

					identical: {

                        field: 'repassword',

                        message: 'The password and its confirm are not the same'

                    },

					stringLength: {

						min: 6 ,

						max: 15,

						message: 'The password length min 6 and max 15 character Long'

					}

				}

			},

			repassword: {

				validators: {					

					identical: {

                        field: 'password',

                        message: 'The password and its confirm are not the same'

                    }

					

				}

			},

        }

    });

    

    });

  </script>

  <!--<script>

    $('#password').keyup(function(){

        //alert();

        if($('#password').val() !== ''){            

            if($('#repassword').val() === ''){

                //alert($('#repassword').val());

                $(':input[type="submit"]').prop('disabled', true);

            }else{

                $(':input[type="submit"]').prop('disabled', false);

            }

        }

    });

  </script>-->

<script>

	CKEDITOR.replace( 'editor1' );

</script>

<script src="<?php echo base_url('front');?>/js/jquery-ui.js"></script>

<script>

  $( function() {

    $( "#datepicker" ).datepicker({

      changeMonth: true,

      changeYear: true,

      yearRange: '1950:2011'

    });

  } );

</script>

<script>

  $( function() {

    $( "#datepicker1" ).datepicker({     

    });

  } );

</script>

<!--<script src="<?php echo base_url('front');?>/js/bootstrap-multiselect.min.js"></script>

<script type="text/javascript">

$(document).ready(function() {

    $('#boot-multiselect-demo').multiselect({

        includeSelectAllOption: true,

        buttonWidth: 250,

        enableFiltering: true

        });

    });

</script>-->

</body>

</html>