$(document).ready(function () {

  // Delete Product
  $(document).on('click', '.delete_product_btn', function (e) {
      e.preventDefault();
      
      var id = $(this).val();

      swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this product!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              $.ajax({
                  method: "POST",
                  url: "code.php",
                  data: {
                      'product_id': id,
                      'delete_product_btn': true
                  },
                  success: function (response) {
                      if (response == 200) {
                          swal("Success!", "Product deleted successfully!", "success");
                          $("#products_table").load(location.href + " #products_table");
                      } else if (response == 500) {
                          swal("Error!", "Something went wrong", "error");
                      }
                  }
              });
          }
      });
  });

  // Delete Category
  $(document).on('click', '.delete_category_btn', function (e) {
      e.preventDefault();
      
      var id = $(this).val();
      //alert(id);

      swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this category!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              $.ajax({
                  method: "POST",
                  url: "code.php",
                  data: {
                      'category_id': id,
                      'delete_category_btn': true
                  },
                  success: function (response) {
                      if (response == 200) {
                          swal("Success!", "Category deleted successfully!", "success");
                          $("#category_table").load(location.href + " #category_table");
                      } else if (response == 500) {
                          swal("Error!", "Something went wrong", "error");
                      }
                  }
              });
          }
      });
  });

  // Delete Supplier
  $(document).on('click', '.delete_supplier_btn', function (e) {
      e.preventDefault();
      
      var id = $(this).val();

      swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this supplier!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              $.ajax({
                  method: "POST",
                  url: "code.php",
                  data: {
                      'supplier_id': id,
                      'delete_supplier_btn': true
                  },
                  success: function (response) {
                      if (response == 200) {
                          swal("Success!", "Supplier deleted successfully!", "success");
                          $("#supplier_table").load(location.href + " #supplier_table");
                      } else if (response == 500) {
                          swal("Error!", "Something went wrong", "error");
                      }
                  }
              });
          }
      });
  });

  // Delete Order
  $(document).on('click', '.delete_order_btn', function (e) {
    e.preventDefault();
    
    var userId = $(this).val();

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this order!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'user_id': userId,
                    'delete_user_btn': true
                },
                success: function (response) {
                    if (response.trim() === '200') {
                        swal("Success!", "Order deleted successfully!", "success");
                        $("#orders_table").load(location.href + " #orders_table");
                    } else if (response.trim() === '500') {
                        swal("Error!", "Something went wrong", "error");
                    }
                },
                error: function() {
                    swal("Error!", "Could not connect to server.", "error");
                }
            });
        }
    });
});

  // Delete User
  $(document).on('click', '.delete_user_btn', function (e) {
      e.preventDefault();
      
      var userId = $(this).val();

      swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this user!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              $.ajax({
                  method: "POST",
                  url: "code.php",
                  data: {
                      'user_id': userId,
                      'delete_user_btn': true
                  },
                  success: function (response) {
                      if (response.trim() === '200') {
                          swal("Success!", "User deleted successfully!", "success");
                          $("#users_table").load(location.href + " #users_table");
                      } else if (response.trim() === '500') {
                          swal("Error!", "Something went wrong", "error");
                      }
                  },
                  error: function() {
                      swal("Error!", "Could not connect to server.", "error");
                  }
              });
          }
      });
  });

});

$(document).ready(function () {
    // Update Supplier Order Status
    $(document).on('click', '.update_supplier_order', function () {
        const orderId = $(this).data('id');
        const status = $(this).data('status');

        swal({
            title: "Are you sure?",
            text: `Mark this order as ${status}?`,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willUpdate) => {
            if (willUpdate) {
                $.ajax({
                    method: "POST",
                    url: "code.php",
                    data: {
                        'update_supplier_order': true,
                        'order_id': orderId,
                        'status': status
                    },
                    success: function (response) {
                        if (response.trim() == '200') {
                            swal("Success!", "Order status updated successfully!", "success")
                                .then(() => location.reload());
                        } else {
                            swal("Error!", "Something went wrong!", "error");
                        }
                    },
                    error: function () {
                        swal("Error!", "Could not connect to the server.", "error");
                    }
                });
            }
        });
    });
});



