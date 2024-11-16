<form action="{{route('user.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="col">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" >
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="user">User:</label>
            <input type="text" id="user" name="user" >
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="password">Password:</label>
            <input type="text" id="password" name="password" >
        </div>
    </div>
    <div class="row">
        <div class="col">
            <button type="subimit" class="btn btn-md">Register</button>
        </div>
    </div>
</form>