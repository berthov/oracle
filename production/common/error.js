$(document).ready(function() {

  $("#formLogin").submit(function(){
  event.preventDefault();

    var username=$("#username").val();
    var password=$("#password").val();

    if(username!="" && password!=""){
       $.ajax({
        type:'post',
        url:'controller/dologin.php',
        data:{
         'username':username,
         'password':password
        },
        success:function(response) {
          if(response=='success'){
            window.location.href="../production/form_ap.php";
          }
          else if (response=='successStaff'){
            window.location.href="../production/form_ap.php"; 
          }
          else {
            toastr.error('Wrong Password or Username');
          }
        }
      });  
    }
  });

  $("#formRegister").submit(function(){
  event.preventDefault();

    var username=$("#usernameregister").val();
    var email=$("#email").val();
    var password=$("#passwordregister").val();
    var cpassword=$("#cpassword").val();
    var divisi=$("#divisi").val();

      $.ajax({
        type:'post',
        url:'controller/doregister.php',
        data:{
         'username':username,
         'password':password,
         'cpassword':cpassword,
         'email':email,
         'divisi':divisi
        },
        success:function(response){
          if(response=='password did not match'){
            toastr.error('Password did not match');
          }
          else if(response=='Username already exist'){
            toastr.error('Username already exist');
          }
          else if(response=='Email already exist'){
            toastr.error('Email already exist');
          }
          else{
            window.location.href="../production/login.php";
          }
        }
    });
  });


  $("#form_ap").submit(function(){
  event.preventDefault();
    // var COUNTER=$("#COUNTER").val();
    var INVOICE_NUM=$("#INVOICE_NUM").val();
    var VENDOR_SITE_CODE=$("#VENDOR_SITE_CODE").val();
    var INVOICE_TYPE_LOOKUP_CODE=$("#INVOICE_TYPE_LOOKUP_CODE").val();
    var INVOICE_DATE=$("#INVOICE_DATE").val();
    var ITEMCOUNTER = [];
    var ITEMDESCRIPTION = [];
    var ITEMAMOUNT = [];
    var EACHCOUNTER;
    var EACHDESCRIPTION;
    var EACHAMOUNT;
    $(".itemdesc").each(function(){
        EACHDESCRIPTION = parseInt(this.value);
        ITEMDESCRIPTION.push(+EACHDESCRIPTION);
    })

    $(".itemamo").each(function(){
        EACHAMOUNT = parseInt(this.value);
        ITEMAMOUNT.push(+EACHAMOUNT);
    })

    $(".itemcoun").each(function(){
        EACHCOUNTER = parseInt(this.value);
        ITEMCOUNTER.push(+EACHCOUNTER);
    })

      $.ajax({
        type:'post',
        url:'controller/doaddinvoice.php',
        data:{
            'COUNTER':ITEMCOUNTER,
            'INVOICE_NUM':INVOICE_NUM,
            'VENDOR_SITE_CODE':VENDOR_SITE_CODE,
            'INVOICE_TYPE_LOOKUP_CODE':INVOICE_TYPE_LOOKUP_CODE,
            'INVOICE_DATE':INVOICE_DATE,
            'AMOUNT':ITEMAMOUNT,
            'DISTRIBUTION_SET_ID':ITEMDESCRIPTION
        },
        success:function(response){
          if(response == 'Access denied'){
            toastr.error('Access denied');
          }
          else if(response=='Invoice already exist'){
            toastr.error('Invoice already exist');
          }
          else{
            window.location.href="../production/form_ap.php";
            // console.log(response);
          }
        }
    });
  });

  $('.btnrefund').click(function() { 

      INVOICE_ID = $(this).attr('data-id');

      $.ajax({
          type:'post',
          url:'controller/cancelinvoice.php',
          data:{
           'INVOICE_ID':INVOICE_ID
          },
          success:function(response) {
            if(response=='C'){
              toastr.error('Invoice Already Cancelled');
            }
            else if(response=='A'){
              toastr.error('Invoice Already Approved Cannot be Cancel, Please Contact Your Admin');
            }
            else{
              window.location.href="../production/summary_request.php";
              // console.log(response)
            }
          }
        });  
      });
      
});