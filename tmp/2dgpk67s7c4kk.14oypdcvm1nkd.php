<!-- Mainly scripts -->
<script src="<?= ($BASE) ?>/ui/backend/js/xregexp-all.js"></script>
<script src="<?= ($BASE) ?>/ui/backend/js/jquery-3.1.1.min.js"></script>
<script src="<?= ($BASE) ?>/ui/backend/js/bootstrap.min.js"></script>
<script src="<?= ($BASE) ?>/ui/backend/js/instafeed.js"></script>
<script src="<?= ($BASE) ?>/ui/backend/js/moment.js"></script>

<script src="<?= ($BASE) ?>/ui/backend/js/axios.min.js"></script>
<script src="<?= ($BASE) ?>/ui/backend/js/vue.min.js"></script>

<script src="<?= ($BASE) ?>/ui/backend/js/jquery.validate.js"></script>
<script src="<?= ($BASE) ?>/ui/backend/js/jquery.form.min.js"></script>
<script src="<?= ($BASE) ?>/ui/backend/js/jquery.fancybox.js"></script>
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<!-- blueimp gallery -->
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
<!-- Flot -->
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/flot/jquery.flot.js"></script>
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/flot/jquery.flot.spline.js"></script>
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/flot/jquery.flot.resize.js"></script>
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/flot/jquery.flot.pie.js"></script>
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/flot/jquery.flot.symbol.js"></script>
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/flot/jquery.flot.time.js"></script>
<!-- FooTable -->
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/footable/footable.all.min.js"></script>
<!-- Jasny -->
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/jasny/jasny-bootstrap.min.js"></script>
<!-- Peity -->
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/peity/jquery.peity.min.js"></script>
<!-- Custom and plugin javascript -->
<script src="<?= ($BASE) ?>/ui/backend/js/inspinia.js"></script>
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/pace/pace.min.js"></script>
<!-- Jvectormap -->
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- EayPIE -->
<!-- Sparkline -->
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- Clock picker -->
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/clockpicker/clockpicker.js"></script>
<!-- Select2 -->
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/select2/select2.full.min.js"></script>
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<!-- Data picker -->
<script src="<?= ($BASE) ?>/ui/backend/js/bootstrap-datepicker.js"></script>
<!-- Full Calendar -->
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/fullcalendar/fullcalendar.min.js"></script>
<!-- iCheck -->
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/iCheck/icheck.min.js"></script>
<!-- SUMMERNOTE -->
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/summernote/summernote.min.js"></script>
<!-- DATATABLES -->
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/dataTables/datatables.min.js"></script>
<!-- Dual Listbox -->
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/dualListbox/jquery.bootstrap-duallistbox.js"></script>
<!-- Toastr script -->
<script src="<?= ($BASE) ?>/ui/backend/js/plugins/toastr/toastr.min.js"></script>
<!-- DROPZONE -->
<!-- Place inside the <head> of your HTML -->
<script type="text/javascript" src="<?= ($BASE) ?>/ui/backend/js/tinymce.min.js"></script>
<script type="text/javascript" src="<?= ($BASE) ?>/ui/backend/js/nestable.js"></script>
<script type="text/javascript" src="<?= ($BASE) ?>/ui/backend/js/sweetalert2.all.min.js"></script>
<!-- Webcam -->
<!-- <script type="text/javascript" src="<?= ($BASE) ?>/ui/backend/js/webcam.min.js"></script> -->
<script src="<?= ($BASE) ?>/ui/backend/js/axios.min.js"></script>
<script src="<?= ($BASE) ?>/ui/backend/js/vue.min.js"></script>

<script type="text/javascript">

$( document ).ready(function() {
    $( ".logout" ).click(function(event) {
      event.preventDefault();
      Swal.fire({
        title: "ອອກຈາກລະບົບ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#193262",
        confirmButtonText: "Yes",
        closeOnConfirm: false
      }).then((result)=>{
        if(result.isConfirmed){
          window.location.href = '<?= ($BASE) ?>/logout';
        }
      });
    });

    $('.ajax-delete').on('click',function(){
      var obj = $(this);
      Swal.fire({
          title: 'ຕ້ອງການລຶບແທ້ບໍ່?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'ຕົກລົງ',
          cancelButtonText: 'ຍົກເລີກ',
          }).then((result) => {
          if (result.isConfirmed){
              $.ajax({
                  type:'delete',
                  url:obj.attr('url'),
                  success:function(data){
                      if(data.success)
                      {
                          Swal.fire('ສຳເລັດ!',data.message,'success');
                          $('#item-'+obj.attr('itemid')).hide();
                      } else {
                          Swal.fire('ຜິດພາດ!','ກະລຸນາລອງໃໝ່ອີກຄັ້ງ','error');
                      }
                  },
                  error:function(){
                      Swal.fire('ຜິດພາດ!','ກະລຸນາລອງໃໝ່ອີກຄັ້ງ','error');
                  }
              })
            }
        })
    });
    
});

function isNumberKey(evt)
{
   var charCode = (evt.which) ? evt.which : evt.keyCode;
   if (charCode != 46 && charCode > 31 
     && (charCode < 48 || charCode > 57))
     return false;
   return true;
}

$('.lightBoxGallery a').fancybox({
    fitToView : true,
    width   : '90%',
    height    : '90%',
    autoSize  : false,
    closeClick  : false,
    openEffect  : 'none',
    closeEffect : 'none',
    pixelRatio: 2,
    helpers: {
      overlay: {
        locked: false
      }
    }
});

function addCommas(nStr)
  {
      nStr += '';
      x = nStr.split('.');
      x1 = x[0];
      x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
          x1 = x1.replace(rgx, '$1' + ',' + '$2');
      }
      return x1 + x2;
  }

</script>