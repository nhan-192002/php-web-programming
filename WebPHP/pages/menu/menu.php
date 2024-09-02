<?php
    // ob_start(); // Bắt đầu bộ đệm đầu ra
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php?pages=product">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php?pages=product">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Category
          </a>
          <ul id="category" class="dropdown-menu">
          
          </ul>
        </li>
        <li class="nav-item">
          <a href="index.php?pages=cart-product" class="nav-link">Cart</a>
        </li>
        <?php
           echo isset($_SESSION['id_user']) ? '<a class="nav-link" aria-current="page" href="index.php?pages=profiles">Profiles</a>' : '<a class="nav-link" aria-current="page" href="index.php?pages=login">Login</a>';
        ?>
      </ul>
      <form class="d-flex" method="POST">
        <input class="form-control me-2" id="search-form" name="search_form" placeholder="Search">
        <button class="btn btn-outline-success" name="search" id="search">Search</button>
      </form>
    </div>
  </div>
</nav>

<script>
  function myFunction(name, id) {
    $.ajax({
      type: "GET",
      url: "pages/main/handle/handle-product.php",
      data: { category: name ,id_category: id },
      success: function(response) {
        document.getElementById('display').innerHTML = response;
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
      }
    });
  }

  $(document).ready(function () {

    $('#search').click(function (e) { 
      e.preventDefault();
      var $search = $('#search-form').val();
      $.ajax({
        type: "POST",
        url: "pages/main/handle/handle-product.php",
        dataType: "html",
        data: { search: $search },
        success: function (response) {
          document.getElementById('display').innerHTML = response;
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
        }
      });
    });
  });

  $(document).ready(function () {
    $.ajax({
      type: "GET",
      url: "pages/menu/handle-menu.php",
      dataType: "html",
      success: function (response) {
        $('#category').html(response);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log('Có lỗi xảy ra: ' + textStatus + ', ' + errorThrown);
      }
    });
  });
</script>
