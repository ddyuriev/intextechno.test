<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users</title>
    <style>
        .user {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .user img {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 4px;
        }

        .nickname {
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Registered users</h2>

@if(empty($users))
    <p>No users yet.</p>
@else
    @foreach($users as $user)
        <div class="user">
            <img
                src="{{ asset('storage/' . $user['avatar']) }}"
                alt="{{ $user['nickname'] }}"
            >
            <span class="nickname">
                {{ $user['nickname'] }}
            </span>
        </div>
    @endforeach
@endif

</body>
</html>
