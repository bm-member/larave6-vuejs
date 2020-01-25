<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todo Vue CRUD</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.css">
</head>

<body>

    <div id="root">
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-6">
                    <h1>@{{ title }}</h1>
                    <form >
                        <div class="input-group mb-3">
                            <input 
                                v-model="newUser"
                                type="text" 
                                class="form-control" 
                                placeholder="Enter User's name"
                            >
                            <div class="input-group-append">

                                <button 
                                    v-if="!editMode" 
                                    class="btn btn-outline-primary"
                                    @click.prevent="addUser"
                                >
                                    Add User
                                </button>

                                <button  
                                    v-else 
                                    class="btn btn-outline-info" 
                                    @click.prevent="updateUser"
                                >
                                    Update User
                                </button>
                            </div>
                        </div>
                    </form>
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        <tr v-for="user in users">
                            <td>@{{ user.id }}</td>
                            <td>@{{ user.name }}</td>
                            <td>
                                <button 
                                @click="editUser(user)"
                                class="btn btn-success btn-sm">
                                    Edit
                                </button>
                                <button 
                                @click="deleteUser(user)"
                                class="btn btn-danger btn-sm">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
    <script>
        new Vue({
        el: "#root",
        data: {
            title: 'Todo List',
            newUser: '',
            user: {},
            users: [],
            editMode: false
        },
        methods: {
            getUsers() {

                var _this = this;

                axios.get('http://localhost:8000/api/user')
                .then(function(res) {
                    _this.users = res.data
                })
            },
            addUser() {

                var _this = this;

                axios.post('http://localhost:8000/api/user', {
                    name: this.newUser
                })
                .then(function(res) {
                    _this.getUsers();
                    _this.newUser = '';
                    Swal.fire("New User was added.")
                })
                .catch(function(err) {
                    console.log(err)
                });
                
            },
            editUser(user) {
                this.editMode = true;
                this.newUser = user.name;
                this.user = user;
            },
            updateUser() {
                var _this = this;

                axios.put('http://localhost:8000/api/user/' + _this.user.id, {
                    name: this.newUser
                })
                .then(function(res) {
                    _this.getUsers();
                    _this.newUser = '';
                    _this.editMode = false
                })
                .catch(function(err) {
                    console.log(err)
                });

            },
            deleteUser(user) {
                var _this = this;

                axios.delete('http://localhost:8000/api/user/' + user.id)
                .then(function(res) {
                    _this.getUsers();
                })
                .catch(function(err) {
                    console.log(err)
                });
            }
        },
        created() {
            this.getUsers();
        }
        })
    </script>
</body>

</html>