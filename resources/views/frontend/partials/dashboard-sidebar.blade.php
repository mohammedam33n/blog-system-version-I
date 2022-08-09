<div class="card">
    <ul class="list-group list-group-flush">

        <li class="list-group-item">
            <a href="{{ route('post.create') }}" class="text-decoration-none text-danger">Create Post</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('dashboard') }}" class="text-decoration-none text-danger">Manage Posts</a>
        </li>

        <li class="list-group-item">
            <a href="{{ route('users.edit_info') }}" class="text-decoration-none text-danger">Update Information</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('users.update_info') }}" class="text-decoration-none text-danger">Change Password</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('logout') }}"onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="text-decoration-none text-danger">Logout</a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>

    </ul>
</div>
