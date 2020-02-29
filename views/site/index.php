<div class="container">
  <h2>Pages</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Id</th>
        <th>Friendly</th>
        <th>Title</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($data as $value) { ?>
      	<tr>
      		<td><?php echo $value['id']; ?></td>
      		<td><?php echo $value['friendly']; ?></td>
      		<td><?php echo $value['title']; ?></td>
      		<td><?php echo $value['description']; ?></td>
      	</tr>
      <?php } ?>
    </tbody>
  </table>
</div>