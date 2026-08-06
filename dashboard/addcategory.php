 <?php
 include 'header.php';
?>
 
 
 <!-- User Modal (Add/Edit) -->
    <div class="container">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" >
                    <form method="POST" >
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Category Name</label>
                                <input type="text" name="c_name" class="form-control" x-model="form.firstName" required="">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category Description</label>
                                <input type="text" name="c_description" class="form-control" x-model="form.lastName" required="">
                            </div>
                         
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="btn" class="btn btn-primary" >Save Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php 
    
    
    
    
    
    ?>