<style>
.checked {
  color: orange;
}
</style>
<table class="table table-customize">
    <thead>
        <tr>
            <th>Review No.</th>
            <th>Sender Image</th>
            <th>Sender Name</th>
            <th>Rating</th>
            <th>Review</th>
            <th>Created Date</th>
            <th>Created TIme</th>
        </tr>
    </thead>
    <tbody id="">
        <?php foreach($reviewListData as $oneRow){ ?>
            <?php $image = $oneRow['image']; ?>
            <tr>
            <td><?php echo $startFrom; ?></td>
                <td>
                    <img width="50" height="50" style="border: 1px solid #ed1b24; border-radius: 100%;" id="pImg" src="<?php echo base_url('upload/profile_image/'.$image);?>">
                </td>
                <td><?php echo $oneRow['username']; ?></td>
                <td>
                    <?php
                        for ($x = 0; $x < 5; $x++) {
                            $fillStars = ' checked';
                            if($oneRow['rating'] <= $x){
                                $fillStars = ' ';
                            }
                            ?>
                            <i class="fa fa-star<?php echo $fillStars; ?>" data-rating="1"></i>
                            <?php
                        }
                    ?>
                </td>
                <td style="width: 350px;" ><?php echo $oneRow['review']; ?></td>
                <td><?php echo date('d M, Y',strtotime($oneRow['crd'])); ?></td>
                <td><?php echo date('h:i a',strtotime($oneRow['crd'])); ?></td>
            </tr>
        <?php $startFrom++; } ?>
    </tbody>
</table>
<?php print_r($links); ?>