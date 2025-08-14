<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <input type="email" name="email" placeholder="Your Email">
    <button type="submit">Send Password Reset Link</button>
</form>
