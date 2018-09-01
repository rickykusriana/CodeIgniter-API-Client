
<center>

<div style="margin-top: 70px;">

	<h4><?=$this->session->flashdata('alert');?></h4>

	<table border="1" width="80%">
		<tr>
			<th>No</th>
			<th>Image</th>
			<th>Nama</th>
			<th>Alamat</th>
			<th>Email</th>
			<th>Telepon</th
			><th>Action</th>
		</tr>

		<?php 
			if ( isset($get_profile['status']) == false) {  
			$no=1; foreach($get_profile as $key) { 
		?>
			
			<tr>
				<td align="center"><?=$no;?></td>
				<td align="center">
					<img src="<?=base_url('upload/'.$key->image);?>" width="100px">
				</td>
				<td><?=$key->name;?></td>
				<td><?=$key->address;?></td>
				<td><?=$key->email;?></td>
				<td><?=$key->phone;?></td>
				<td align="center">
					<?=anchor('profile/update/'.$key->id, 'Edit |');?>
	                <a href="<?=site_url('profile/delete/'.$key->id);?>" onclick="return confirm('Are you sure?')">Delete</a>
	            </td>
			</tr>

		<?php 
			$no++; } 
			} else { 
		?>
			<tr>
				<td colspan="6">Data not found</td>
			</tr>

		<?php } ?>

	</table>

	<p>
		<a href="<?=site_url('profile/create');?>">Tambah Data</a>
	</p>

</div>
</center>