<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> -->

    <link rel="stylesheet" href="{{asset('asset/css/bootstrap.min.css')}}">
    <style>
        * {
            font-family: phetsarath OT;
        }
    </style>
    <title>Category</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Axios CRUD</h1>
        <hr>
        <div class="row">
            <div class="col-8">
                <h4>Manage Category</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>lname</th>
                        <th>Actions</th>
                    </tr>
                    <tbody id="tbody">

                    </tbody>
                </table>
            </div>
            <div class="col-4">
                <h4>Add New Category</h4>
                <form id="addNewDataForm">
                    <div class="form-group">
                        <input type="text" class="form-control" id="fname" placeholder="first name" required>
                        <span id="error" class="text-danger"></span>
                    </div>
                    <div class="form-group mt-2">
                     
                        <input type="text" class="form-control" id="lname" placeholder="last name" required>
                     
                    </div>
                    <div class="form-group">
                        <button class="btn btn-sm btn-block btn-success" type="submit">Add New Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editDataForm">
                        <div class="form-group">
                            <input type="text" class="form-control" id="e_fname" placeholder="first name">
                            
                            <input type="hidden" id="e_id">
                            <span id="error" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                        
                            <input type="text" class="form-control" id="e_lname" placeholder="last name">
                           
                            <span id="error" class="text-danger"></span>
                        </div>
                        <div class="form-group">

                            <button class="btn btn-sm btn-block btn-success" type="submit">ແກ້ໄຂ</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> -->
      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> -->
       <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script> -->
         <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->
    <script src="{{asset('asset/js/jquery-3.2.1.slim.min.js')}}"></script>
    <script src="{{asset('asset/js/popper.min.js')}}"></script>
    <script src="{{asset('asset/js/bootstrap.min.js')}}"></script>  
    <script src="{{asset('asset/js/axios.min.js')}}"></script>
    <script src="{{asset('asset/js/sweetalert2.all.min.js')}}"></script>

    <script>
        let url = window.location.origin

        function table_data_row(data) {
            var rows = '';
            var i = 0;
            $.each(data, function(key, value) {
                rows = rows + '<tr>';
                rows = rows + '<td>' + ++i + '</td>';
                rows = rows + '<td>' + value.fname + '</td>';
                rows = rows + '<td>' + value.lname + '</td>';
                rows = rows + '<td data-id="' + value.id + '" class="text-center">';
                rows = rows + '<a class="btn btn-sm btn-info text-light" id="editRow" data-id="' + value.id + '" data-toggle="modal" data-target="#editModal">Edit</a> ';
                rows = rows + '<a class="btn btn-sm btn-danger text-light"  id="deleteRow" data-id="' + value.id + '" >Delete</a> ';
                rows = rows + '<a class="btn btn-sm btn-success text-light"  id="viewRow" data-id="' + value.id + '" >View</a> ';
                rows = rows + '</td>';
                rows = rows + '</tr>';
            });
            $("#tbody").html(rows);
        }

        function getAllData() {
            axios.get("{{route('get-all-cat')}}")
                .then(function(res) {
                    table_data_row(res.data)
                    // console.log(res.data);
                })
        }
        getAllData();
        // store
        $('body').on('submit', '#addNewDataForm', function(e) {
            e.preventDefault();
            axios.post("{{route('category.store')}}", {
                    fname: $('#fname').val(),
                    lname: $('#lname').val(),
                })
                .then(function(response) {
                    getAllData();
                    $('#fname').val('');
                    $('#lname').val('');
                    $('#error').text('');
                    Swal.fire({
                        icon: 'success',
                        title: 'ບັນທຶກສຳເລັດແລ້ວ',
                    })
                })
                .catch(function(error) {
                    if (error.response.data.errors.name) {
                        $('#error').text(error.response.data.errors.name[0]);
                    }
                });

        });
        //delete

        //delete
        //delete currency
        $('body').on('click', '#deleteRow', function(e) {
            e.preventDefault();
            let id = $(this).data('id')
            // let del = url + '/category/' + id
            // console.log(del)
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success mx-2',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'ທ່ານຕ້ອງການລຶບແທ້ບໍ່?',
                text: "ທ່ານຈະບໍ່ສາມາດນຳກັບຄືນມາໄດ້!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "<i class='fa fa-window-close'></i>ຕົກລົງ",
                cancelButtonText: "<i class='fa fa-window-close'></i>ຍົກເລີກ",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`${url}/category/${id}`).then(function(r) {
                        getAllData();
                        swalWithBootstrapButtons.fire(
                            'ລືບ!',
                            'ຂໍ້ມູນຖືກລົບຮຽບຮ້ອຍແລ້ວ',
                            'success'
                        )
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'ຍົກເລີກ',
                        'ຂໍ້ມູນຂອງທ່ານບໍ່ໄດ້ຖືກລົບ',
                        'error'
                    )
                }
            })
        });

        $('body').on('click', '#editRow', function() {
            let id = $(this).data('id');
            let edit = url + '/category' + '/' + id + '/edit'
            // console.log(url);
            axios.get(edit)
                .then(function(res) {
                    console.log(res);
                    $('#e_fname').val(res.data.fname)
                    $('#e_lname').val(res.data.lname)
                    $('#e_id').val(res.data.id)
                })
        })
        //update
        $('body').on('submit','#editDataForm',function(e){
        e.preventDefault()
        let id = $('#e_id').val()
        let data = {
            id : id,
            fname : $('#e_fname').val(),
            lname : $('#e_lname').val(),
        }
        let path = url + '/category' + '/'  + id
        axios.put(path,data)
        .then(function(res){
            getAllData();
             $('#editModal').modal('toggle')
    Swal.fire({
                icon: 'success',
                title: 'ສຳເລັດ...',
                text: 'ແກ້ໄຂສຳເລັດແລ້ວ!',
                })
                console.log(res);
            })
        })
    </script>

</body>

</html>