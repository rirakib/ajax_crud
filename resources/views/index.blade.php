<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <h1 id="createTitle">Create Data</h1>
    <h1 id="updateTitle">Update Data</h1>
    <form id="frm">
        <input type="text" placeholder="Name" id="name" required /></br></br>
        <input type="email" placeholder="Email" id="email" required /></br></br>
        <input type="text" placeholder="Mobile" id="mobile" required /></br></br>
        <input type="hidden" id="id">
        <Button id="submit">Create</Button>
        <Button id="update">Update</Button>
    </form>

    <h1>Data Table</h1>
    <select name="" id="table_show">
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="15">15</option>
    </select></br></br>
    <table border="1">
        <thead>
            <td>ID</td>
            <td>Name</td>
            <td>Email</td>
            <td>Mobile</td>
            <td>Edit</td>
            <td>Delete</td>
        </thead>
        <tbody>
            
        </tbody>
    </table>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer">
    </script>
    <script>
        $('#updateTitle').hide();
        $('#update').hide();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script>
        function allData() {
            $.ajax({
                type: 'get',
                dataType: 'json',
                url: 'contact/all',
                success: function (data) {
                    var table_inner = '';
                    $.each(data, function (key, value) {
                        table_inner = table_inner + "<tr>";
                        table_inner = table_inner + "<td>" + value.id + "</td>";
                        table_inner = table_inner + "<td>" + value.name + "</td>";
                        table_inner = table_inner + "<td>" + value.email + "</td>";
                        table_inner = table_inner + "<td>" + value.mobile + "</td>";
                        table_inner = table_inner + "<td>" + "<button onclick='editButton("+value.id+")'>Edit</button>" + "</td>";
                        table_inner = table_inner + "<td>" + "<button onclick='deleteButton("+value.id+")'>Delete</button>" + "</td>";
                        table_inner = table_inner + "<tr>";
                        table_inner = table_inner + "</tr>";
                    })
                    $('tbody').html(table_inner);
                }

            })
        }
        allData();
        function clearData(){
            $('#name').val('');
            $('#email').val('');
            $('#mobile').val('');
        }

        

            $('#submit').click(function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',

                    dataType: 'json',
                    data: {
                        name: $('#name').val(),
                        email: $('#email').val(),
                        mobile: $('#mobile').val()
                    },
                    url: 'cotnact/store',

                    success: function (data) {
                        clearData();
                        allData();
                        console.log('successfully data added');
                    }

                })

            })
        
        function editButton(id){
            $('#createTitle').hide();
            $('#updateTitle').show();
            $('#submit').hide();
            $('#update').show();
            $.ajax({
                type:'get',
                dataType:'json',
                url:'contact/edit/'+id,
                success: function(data){
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#mobile').val(data.mobile);
                }
            })
        }

        $('#update').click(function(e){
            e.preventDefault();
           var id = $('#id').val();
            $.ajax({
                type:'post',
                dataType:'json',
                url:'contact/update/'+id,
                data:{
                    name:$('#name').val(),
                    email:$('#email').val(),
                    mobile:$('#mobile').val()
                },
                success:function(data){
                    clearData();
                    allData();
                    $('#createTitle').show();
            $('#updateTitle').hide();
            $('#submit').show();
            $('#update').hide();
                    console.log(data)
                }
            })
        })
        function deleteButton(id){
            $.ajax({
                type:'get',
                dataType:'json',
                url:'contact/delete/'+id,
                success: function(data){
                    allData();
                }
            })
        }
        
    </script>
</body>

</html>