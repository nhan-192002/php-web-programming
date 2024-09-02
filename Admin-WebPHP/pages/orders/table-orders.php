<div id="page-wrapper">
    <section style="background-color: #FFFFFF;">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div id="display-user-order" class="card">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Table order</h2>  
                
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover load-orders" id="dataTables-example">
                                
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
        load_orders();
    });

    function load_user_orders(id_pay){
        $.ajax({
            type: "GET",
            url: "pages/orders/handle/handle-orders.php",
            data: {action: 'load-user-orders', id_pay_orders: id_pay},
            dataType: "html",
            success: function (response) {
                $('#display-user-order').html(response);
            }
        });
    }


    function load_orders(){

        $.ajax({
            type: "GET",
            url: "pages/orders/handle/handle-orders.php",
            data: {action: 'load-orders'},
            dataType: "html",
            success: function (response) {
                $('.load-orders').html(response);
            }
        });
    }

    function order_details(id_pay, id_user){
        $.ajax({
            type: "GET",
            url: "pages/orders/handle/handle-orders.php",
            data: {action: 'load-order-details', id_pay: id_pay, id_user:id_user},
            dataType: "html",
            success: function (response) {
                $('.load-orders').html(response);
                load_user_orders(id_pay);               
            }
        });
    }

    function confirm_order(id_pay){
        var confirmation = confirm("Bạn có chắc muốn xác nhận đơn hàng");
        if (confirmation) {
            $.ajax({
                type: "POST",
                url: "pages/orders/handle/handle-orders.php",
                data: {id_pay_confirmOrder: id_pay},
                dataType: "html",
                success: function (response) {
                    alert(response);
                    load_orders();
                }
            });   
        }

    }

    function back_order_details(){
        load_orders();
        $('#display-user-order').html('');
    }
</script>