@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        {{-- <button id="button" class="mb-2">Row Count</button> --}}
        <a id="button-add" href="{{ route('add.user') }}" class="btn btn-primary mb-2">Add User</a>
        <a id="toExcellButton" href="{{route('toexcel')}}" class="btn btn-primary mb-2">Excel</a>
        <a id="toPdflButton" href="" class="btn btn-primary mb-2">Print/PDF</a>
        <!-- Modal -->
        <div id="updateModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title">Update</h4>
                        <button type="button" id='closemodal' class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter a name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter an email">
                        </div>

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" placeholder="Enter the title">
                        </div>

                        <div class="form-group">
                            <label for="birth_date">Birth Date</label>
                            <input type="date" class="form-control" id="birth_date" min="1950-01-01" max="2030-12-31"
                                placeholder="Enter the Birth Date">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" id="hidden_id" value="0">
                        <button type="button" class="btn btn-success btn-sm" id="btn_save">Save</button>
                        <button type="button" class="close btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        {{-- End Modal --}}
        <table class="table  hover table-bordered yajra-datatable" style='width:100%'>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Birth Date</th>
                    <th>Title</th>
                </tr>
            </tfoot>
        </table>
    </div>

    </body>
    <script type="text/javascript">
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        function fixDateTime(date) {

            let arrayDate = date.split("-");
            let year = arrayDate[0];
            let month = arrayDate[1];
            let day = arrayDate[2];

            if (month.length < 2) {
                month = '0' + month;
            }
            if (day.length < 2) {
                day = '0' + day;
            }
            let finaldate = year + "-" + month + "-" + day;
            return finaldate;
        }
        


        $(function() {
            // Setup - add a text input to each footer cell
            $('.yajra-datatable tfoot th').each(function() {
                let title = $(this).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            });

            // Mouse Hover highlighting the rows and columns
            $('.yajra-datatable tbody').on('mouseenter', 'td', function() {
                let colIdx = table.cell(this).index().column;

                $(table.cells().nodes()).removeClass('highlight');
                $(table.column(colIdx).nodes()).addClass('highlight');
            });



            let table = $('.yajra-datatable').DataTable({

                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                pagingType: 'full_numbers',
                stateSave: true,
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'birth_date',
                        name: 'birth_date'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'action'
                    },

                ],
                initComplete: function() {
                    //footerserach
                    this.api()
                        .columns()
                        .every(function() {
                            let that = this;

                            $('.yajra-datatable tfoot input', this.footer()).on('keyup change clear', function() {
                                if (that.search() !== this.value) {
                                    that.search(this.value).draw();
                                }
                            });
                        });
                },
            });

            table.buttons().remove()
            document.getElementById('toPdflButton').addEventListener('click',()=>{
                var printWindow = window.open( "{{route('pdfpage')}}", 'Print')},false);
            // //select rows
            // $('.yajra-datatable tbody').on('click', 'tr', function () {
            //     $(this).toggleClass('selected');
            // });

            // ///Row Count and ids
            // $('#button').click(function () {
            //     let valueString='';
            //     let selectedCount=table.rows('.selected').data().length;
            //    // console.log( table.rows('.selected').data()[0] ); //to get the data from the row
            //     for (let i = 0; i < selectedCount; i++) {
            //         let temp=table.rows('.selected').data()[i]; //setting temp letiable to the object
            //         valueString += ' '+temp['id']; //getting the id out of the object and adding it to the valueString
            //     }
            //     alert(table.rows('.selected').data().length + ' row(s) selected'+'ids of those rows:'+valueString);
            // });

            //Delete row
            $('.yajra-datatable').on('click', '.deleteUser', function() {
                let id = $(this).data('id');
                let deleteConfirm = confirm("Are you sure?");
                if (deleteConfirm == true) {

                    $.ajax({
                        url: "{{ route('delete') }}",
                        type: 'post',
                        data: {
                            _token: CSRF_TOKEN,
                            id: id
                        },
                    })
                    table.ajax.reload();
                }
            });
            
            $('.yajra-datatable').on('click', '.copyUser', function() {
                let id = $(this).data('id');
                let name= $(this).data('name');
                let email= $(this).data('email');
                let birth_date= $(this).data('birth_date');
                let title= $(this).data('title');
                let copyText=id+" ; "+name+" ; "+email+" ; "+birth_date+" ; "+title;
                navigator.clipboard.writeText(copyText);
                console.log(id);
            });
            //Edit
            $('.yajra-datatable').on('click', '.updateUser', function() {
                let id = $(this).data('id');
                $('#updateModal').modal('toggle');
                $('#hidden_id').val(id);

                // AJAX request
                $.ajax({
                    url: "{{ route('update') }}",
                    type: 'post',
                    data: {
                        _token: CSRF_TOKEN,
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success == 1) {

                            $('#name').val(response.name);
                            $('#email').val(response.email);
                            $('#title').val(response.title);
                            $('#birth_date').val(fixDateTime(response.birth_date));


                        } else {
                            alert("Invalid ID.");
                        }
                    }
                });

            });



            //Close modal with X and Close button
            $('.close').click(function() {
                $('#updateModal').modal('toggle');
            });

            // Save user 
            $('#btn_save').click(function() {
                let id = $('#hidden_id').val();

                let name = $('#name').val().trim();
                let email = $('#email').val().trim();
                let title = $('#title').val().trim();
                let birth_date = $('#birth_date').val().trim();

                if (name != '' && email != '' && title != '' && birth_date != '') {

                    // AJAX request
                    $.ajax({
                        url: "{{ route('store') }}",
                        type: 'post',
                        data: {
                            _token: CSRF_TOKEN,
                            id: id,
                            name: name,
                            email: email,
                            title: title,
                            birth_date: birth_date
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success == 1) {
                                alert(response.msg);

                                // Empty and reset the values
                                $('#name', '#email', '#title', '#birth_date').val('');
                                $('#hidden_id').val(0);

                                // Close modal
                                $('#updateModal').modal('toggle');
                                table.ajax.reload();
                            } else {
                                alert(response.msg);
                            }
                        }
                    });

                } else {
                    alert('Please fill all fields.');
                }
            });


        });
    </script>
@endsection
