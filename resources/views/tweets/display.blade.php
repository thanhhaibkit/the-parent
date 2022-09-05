<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Display</title>
</head>
<body>
    <a href="{{ url('refresh') }}">
        Refresh Data
    </a>

    <h2>List tweets</h2>
    <table border="1">
        <tr>
            <td>ID</td>
            <td>Author ID</td>
            <td>Text</td>
        </tr>
        @foreach($tweets as $tweet)
            <tr>
                <td>{{ $tweet->tweet_id }}</td>
                <td>{{ $tweet->author_id }}</td>
                <td>{{ $tweet->text }}</td>
            </tr>
        @endforeach
    </table>

    <h2>Top User</h2>
    <table border="1">
        <tr>
            <td>User ID</td>
            <td>Count</td>
        </tr>
        @isset ($mostUser)
        <tr>
            <td>{{ $mostUser->user_id }}</td>
            <td>{{ $mostUser->count }}</td>
        </tr>
        @endisset
    </table>


    <h2>Top Domains</h2>
    <table border="1">
        <tr>
            <td>Domain</td>
            <td>Count</td>
        </tr>
        @foreach ($mostDomains as $domain)
            <tr>
                <td>{{ $domain->domain }}</td>
                <td>{{ $domain->count }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>