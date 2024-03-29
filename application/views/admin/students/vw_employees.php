<?php $this->load->view('admin/includes/head',['body'=>'']);//sidebar-xs ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pages/datatables_basic.js"></script>
<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/assets/admin/css/bootstrap-switch.css"/>-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/bootstrap-switch.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/main.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/highlight.js"></script>
<form method="post" id="employees">
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title"><?php echo isset($page_title)?$page_title:'Dashboard';?>
        	<div class="pull-right">
        		<div class="heading-btn-group">
<?php 
$school_id = $this->input->get('school_id')?$this->input->get('school_id'):'';
?>
					<div class="pull-right">
        			<?php if (isset($add_link) && $add_link != '') { ?>
        			<a href="<?php echo site_url($add_link); ?>" class="btn btn-sm btn-primary "><i class="fa fa-plus"></i> <span class="hidden-xs"><?php echo $add_title; ?></span> </a>
       			<!-- <div class=" hidden-lg hidden-md hidden-sm m-b-md"></div> -->
        			<?php } ?>
        			<a href="<?php echo site_url('admin/students/download_sheet/'.$school_id); ?>" class="btn btn-sm btn-primary "><i class="fa fa-download"></i> <span class="hidden-xs"><?php echo $this->lang->line("download");?></span></a>
        			 <a href="<?php echo site_url('admin/students/make_zip/'.$school_id); ?>" class="btn btn-sm btn-primary "><i class="fa fa-download"></i> <span class="hidden-xs"><?php echo $this->lang->line("download_all_attachments");?></span></a>
        			 <!-- <div class=" hidden-lg hidden-md hidden-sm m-b-md"></div> -->
        			<!--<a href="<?php echo site_url('admin/students/archived'); ?>" class="btn btn-sm btn-primary "><i class="fa fa-download"></i> <span class="hidden-xs">Archived</a> -->
        			<a href="javascript:;"</ class="btn btn-sm btn-danger bulk_delete_btn"><i class="fa fa-trash"></i> <span class="hidden-xs"><?php echo $this->lang->line("delete");?></span></a>
        			<!-- <div class=" hidden-lg hidden-md hidden-sm m-b-md"></div> -->
        		</div>
        		
        		</div>
        	</div>

        </h5>
    </div>
    <?php
    $user_data = $this->session->userdata('shoppalatt_admin');
    $admin_id = isset($user_data['user_id']) ? $user_data['user_id'] : 0;
    $user_data_shop = $this->session->userdata('shoppalatt_shop');
    $shop_id = isset($user_data_shop['shop_id']) ? $user_data_shop['shop_id'] : 0;
    $admin_uri = $this->uri->segment(1);
    ?>
	
    <!-- <div class=" ">-->
    <table class="table " id="example">

        <thead>
            <tr>
                <th width="4%"  class="no-sort"> <?php echo $this->lang->line("sr_number");?></th>
                
                <th  width="18%"><?php echo $this->lang->line("name");?></th>
                <th  width="12%"><?php echo $this->lang->line("dob");?></th>
                <th  width="12%"><?php echo $this->lang->line("grade");?></th>
                <!-- <th  width="20%">Address</th> -->
                <th  width="15%"><?php echo $this->lang->line("school");?></th>
                
                <th><?php echo $this->lang->line("created_at");?></th>
                <th><?php echo $this->lang->line("status");?></th>
                <!-- <th>Updated At</th> -->
                
               <th width="13%"><?php echo $this->lang->line("action");?></th>
                <!--<th class="text-center" style="width: 175px;">Action</th>-->
            </tr>
        </thead>
        <tbody>
           

        </tbody>

    </table>
    <div class="col-xs-12" style="margin-top: -28px;margin-left: 5px;">
    	<label><input data-switch-no-init type="checkbox" id="select_all" value="1"> <?php echo $this->lang->line("select_all");?></label>
    </div>
    
    

</div>
</form>
<div class="modal fade" id="modal-id">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?php echo $this->lang->line('delete');?></h4>
			</div>
			<div class="modal-body">
				<?php echo $this->lang->line('are_you_sure');?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
				<button type="button" class="btn btn-primary" id="Delete_Joke"><?php echo $this->lang->line('yes');?></button>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('admin/includes/footer'); ?>
<script>
	$(document).on('click','#select_all',function() {
		if($(this).is(':checked')){
			$('.bulk_delete').prop('checked',true);	
		}else{
			$('.bulk_delete').prop('checked',false);
		}
		
	});
	$(document).on('keypress',function(event){
		var modal_status = $('#modal-id').css('display');
		if(event.keyCode == 13 && modal_status =='block') {
			$('#Delete_Joke').trigger('click');

		}
	});
	$(document).on('click','.bulk_delete_btn',function(){
    	var total_selected = $('.bulk_delete:checked').length;
    	//alert(total_selected);
    	if(total_selected>0){
    		$('#employees').submit();	
    	}else{
    		alert('<?php echo $this->lang->line('atleast_one_recrod');?>');
    	}
    });
	var table='';
   $(document).ready(function() {
   	//$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { console.log(message)};
 
    table = $('#example').DataTable( {
    	 "lengthMenu": [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
        "processing": true,
        "serverSide": true,
         "order": [],
        "ajax": {
            "url": "<?php echo site_url('admin/students/ajax_list');?>",
            "type": "POST",
            "data":{'school_id':<?php echo $this->input->get('school_id')?$this->input->get('school_id'):0;?>}
        },
       
    });
    var glob_obj = '';
    $(document).on('click','.delete_joke',function(){
    	glob_obj = $(this);
    	console.log(glob_obj.closest('tr'));
    	var ques_id = $(this).data('id');
    	$('#modal-id').attr('data-id',ques_id);
    });
    $(document).on('click','#Delete_Joke',function(){
    	var ques_id = $('#modal-id').attr('data-id');
    	$.ajax({
                url: "<?php echo base_url(); ?>admin/students/delete_student",
                type: "POST",
                data: {ques_id:ques_id},
                success: function (response) {
                   
                  	//console.log(glob_obj);
                   //if(response.data)
                   {
                   	
                   	//glob_obj.closest('tr').remove();
                   	table
        .row( glob_obj.parents('tr') )
        .remove()
        .draw();

                   	//table.reload();
                   	//table.clear().draw();
                   	$('#modal-id').modal('hide');
                   }
                   


                },
                error: function (jqXHR, textStatus, errorThrown) {
                  alert('Something went wrong, Try again.');

                }


            });
    });
} );

</script>