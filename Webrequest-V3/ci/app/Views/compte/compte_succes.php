<?php $session = session(); ?>

<div id='content-wrapper' class='d-flex flex-column'>
<div id='content'>
<div class='container-fluid'>
<br />
<h2 class='font-weight-bold'>Bravo ! Formulaire rempli, le compte suivant a été ajouté :</h2>
<br />
<div class="table-responsive">
 <table class="table table-striped table-bordered">
  <thead class ="thead-dark">
    <tr>
      <th scope="col">Mail</th>
      <th scope="col"><?php echo $le_message; ?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row"> <?php echo $le_compte ?> </th>
      <td> <?php echo $le_total->nbrComptes; ?> </td>
    </tr>
  </tbody>
</table>
</div>

</div>
</div>
</div>