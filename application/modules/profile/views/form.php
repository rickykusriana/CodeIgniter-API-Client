<?=form_open_multipart($action);?>
    
    <center>
    <div style="margin-top: 70px;">

        <h4><?=$this->session->flashdata('alert');?></h4>

        <table width="80%">
            <tr>
                <td width="10%">Nama</td>
                <td>
                    <input required type="text" name="name" value="<?=($this->uri->segment(2) == 'create') ? set_value('name') : $query[0]->name;?>">
                </td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>
                    <input required type="text" name="address" value="<?=($this->uri->segment(2) == 'create') ? set_value('address') : $query[0]->address;?>">
                </td>
            </tr>
            <tr>
                <td>Email</td>
                <td>
                    <input required type="email" name="email" value="<?=($this->uri->segment(2) == 'create') ? set_value('email') : $query[0]->email;?>">
                </td>
            </tr>
            <tr>
                <td>Telepon</td>
                <td>
                    <input required type="number" name="phone" value="<?=($this->uri->segment(2) == 'create') ? set_value('phone') : $query[0]->phone;?>">
                </td>
            </tr>

            <tr>
                <td>Foto</td>
                <td>
                    <?php 
                        $required = 'required'; 
                        if ($this->uri->segment(2) == 'update') { 
                            $required = ''; 
                    ?>

                        <br><img src="<?=base_url('upload/'.$query[0]->image);?>" width="100px"><br><br>

                    <?php } ?>

                    <input <?=$required;?> type="file" name="image">
                </td>
            </tr>

            <tr>
                <td>
                    <br>
                    <?=form_submit('submit', $button);?>
                    <?=anchor('profile', 'Kembali');?>
                </td>
            </tr>
        </table>
    </div>
    </center>

<?=form_close();?>