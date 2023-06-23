@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div>
                <h1>Total User: <span id="TotalUser"></span></h1>
            </div>
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Sr.no</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
{{-- edit model --}}

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <form id="myform">
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName">
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="lastName">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password Confirmation</label>
                    <input type="password" class="form-control" id="passwordConfirmation" name="passwordConfirmation">
                </div>

                <input type="hidden" id="id" name="id">

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    </div>
</div>

        </div>
    </div>
</div>

@section('scripts')

<script>

    $.ajax({
    url : "{{ route('getdata') }}",
    type: "get",

    success:function(data)

    {

        $('#TotalUser').html(data.length);

        var table = $('#example').DataTable({
            data: data,
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'last_name' },
                { data: 'email' },
                {
            data: null,
            render: function (data, type, row) {
                return '<button class="btn btn-primary btn-sm" onclick="editRow('+data.id+')">Edit</button> ' +
                       '<button class="btn btn-danger btn-sm" onclick="deleteRow('+data.id+')">Delete</button>';
            }
        }
            ]
        });


    }

});


function getdata(){

    $.ajax({
    url : "{{ route('getdata') }}",
    type: "get",

    success:function(data)

    {

        $('#TotalUser').html(data.length);

        $('#example').DataTable().destroy();

        var table = $('#example').DataTable({
            data: data,
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'last_name' },
                { data: 'email' },
                {
            data: null,
            render: function (data, type, row) {
                return '<button class="btn btn-primary btn-sm" onclick="editRow('+data.id+')">Edit</button> ' +
                       '<button class="btn btn-danger btn-sm" onclick="deleteRow('+data.id+')">Delete</button>';
            }
        }
            ]
        });


    }

});



}


function deleteRow(id) {
    $.ajax({
        url : "{{ route('delete') }}",
        type: "post",
        data: {
            id: id,
            _token: "{{ csrf_token() }}"
        },

        success:function(data)

        {
            // alert('User deleted successfully');

            // add toast message


            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
                });

                Toast.fire({
                icon: 'success',
                title: 'User deleted successfully'
                });
            getdata();
        }

    });
}


function editRow(id) {
    $.ajax({
        url : "{{ route('edit') }}",
        type: "post",
        data: {
            id: id,
            _token: "{{ csrf_token() }}"
        },

        success:function(data)

        {
            $('#editModal').modal('show');
            $('#id').val(data.id);
            $('#firstName').val(data.name);
            $('#lastName').val(data.last_name);
            $('#email').val(data.email);
        }

    });
}

$('#myform').validate({
    rules: {
        firstName: {
            required: true,
            minlength: 3,
            maxlength: 15
        },
        lastName: {
            required: true,
            minlength: 3,
            maxlength: 15
        },
        email: {
            required: true,
            email: true
        },
        password: {
            required: true,
            minlength: 3,
            maxlength: 15
        },
        passwordConfirmation: {
            required: true,
            minlength: 3,
            maxlength: 15,
            equalTo: "#password"
        }
    },
    messages: {
        firstName: {
            required: "Please enter your first name",
            minlength: "Your first name must be at least 3 characters long",
            maxlength: "Your first name must be at most 15 characters long"
        },
        lastName: {
            required: "Please enter your last name",
            minlength: "Your last name must be at least 3 characters long",
            maxlength: "Your last name must be at most 15 characters long"
        },
        email: {
            required: "Please enter your email",
            email: "Please enter valid email"
        },
        password: {
            required: "Please enter your password",
            minlength: "Your password must be at least 3 characters long",
            maxlength: "Your password must be at most 15 characters long"
        },
        passwordConfirmation: {
            required: "Please enter your password confirmation",
            minlength: "Your password confirmation must be at least 3 characters long",
            maxlength: "Your password confirmation must be at most 15 characters long",
            equalTo: "Your password confirmation must be same as password"
        }
    }


});




$('#myform').submit(function(e) {
    e.preventDefault();
    var id = $('#id').val();
    var firstName = $('#firstName').val();
    var lastName = $('#lastName').val();
    var email = $('#email').val();
    var password = $('#password').val();
    var passwordConfirmation = $('#passwordConfirmation').val();

    $.ajax({
        url : "{{ route('update') }}",
        type: "post",
        data: {
            id: id,
            firstName: firstName,
            lastName: lastName,
            email: email,
            password: password,
            passwordConfirmation: passwordConfirmation,
            _token: "{{ csrf_token() }}"
        },

        success:function(data)

        {
            $('#editModal').modal('hide');
            // alert('User updated successfully');

            // add toast message

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
                });

                Toast.fire({
                icon: 'success',
                title: 'User updated successfully'
                });
            getdata();
        }

    });
});

</script>

@endsection



@endsection
