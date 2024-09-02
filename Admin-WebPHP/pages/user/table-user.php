<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Table user</h2>  
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group" style="margin: auto;justify-content: right;display: flex;">
                    <select id="filter" class="form-control" name="filter" style="width: 10%; height: 40px;">
                        <option value="" disabled selected>filter</option>
                        <option value="email">Email</option>
                        <option value="name">Name</option>
                        <option value="address">Address</option>
                    </select>
                </div>
                <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>address</th>
                                        <th>Phone</th>
                                        <th>User</th>
                                    </tr>
                                </thead>
                                <tbody id="load-user">
                                
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!--End Advanced Tables -->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
       load_user();
       
        $('#filter').change(function(){
            var filter = $(this).val();
            
            console.log(filter);
            load_user(filter);
        });
    });

    function load_user(filter){
        $.ajax({
            type: "GET",
            url: "pages/user/handle/handle-user.php",
            data: {action:'load-user', filter:filter},
            dataType: "html",
            success: function (response) {
                $('#load-user').html(response);
            }
        });
    }

    function userlock(id){
        var confirmation = confirm("Bạn có chắc chắn thực hiện hành động này");
        if (confirmation) {
            $.ajax({
                type: "POST",
                url: "pages/user/handle/handle-user.php",
                data: {id_user:id},
                dataType: "html",
                success: function (response) {
                    alert(response);
                    load_user();
                }
            });
        }
    }
</script>