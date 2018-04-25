<br/>
			<br/>
			<label>URL: </label>
			<div class="input-group">
				<input type="text" class="form-control" id="url" placeholder="Enter url">
				<span class="input-group-addon" id="btnsubmit">Submit</span>
			</div>

			<div class="input-group" style="margin-top: 20px;">
				<input type="text" id="id_title" name="title" class="form-control" placeholder="" >
				<span class="input-group-addon" id="sb_title" data-toggle="modal">Chose title</span>
			</div>
			<div class="input-group" style="margin-top: 20px;">
				<textarea name="txtare_content" id="id_content" name="content" class="form-control" placeholder=""></textarea>
				<span class="input-group-addon" id="sb_content" data-toggle="modal">Chose Content</span>
			</div>
			<div class="select" style="margin-top: 20px;" >
				<?php $get_categories = get_categories();// print_r($get_categories); ?>
				<select class="col-md-4" name="category" id="category">
					<?php foreach($get_categories as $c){  ?>
						<option value="<?php echo $c->term_id ?>"><?php echo $c->name; ?></option>
					<?php } ?>
				</select>
				<select id="option" name="option" class="col-md-4">
					<option value="wpmedia">WP Media</option>
					<option value="awss3">AWS S3</option>
				</select>
				<select id="status" name="status" class="col-md-4">
					<option value="publish">Publish</option>
					<option value="draft">Draft</option>
				</select>
				<div class="save" style="margin-left: -16px;">
					<button type="button" id="ok" class="btn btn-success" style="margin-top: 20px;">Save Post</button>
				</div>
			</div>
<!-- 		</div> -->
		   <div class="modal fade" id="myModal" role="dialog">
			    <div class="modal-dialog">
			      <div class="modal-content" style="width:1080px;margin-left: -200px;height: auto;">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title">Please selector</h4>
			        </div>
			        <div class="modal-body" style="">
			    	</div>
			        <div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        </div>
			      </div>
			    </div>
			</div>