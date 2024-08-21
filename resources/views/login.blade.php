<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
    <div class="form-container bg-white p-4 p-md-5"
        style="width: 32rem; border: 1.2px solid #ddd; border-radius: 10px;">
        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="mb-4 text-center">
                <h1 class="fw-bold">Login</h1>
                <p>Sign in to your account!</p>
            </div>

            <!-- Email input -->
            <div class="mb-4">
                <div class="form-outline">
                    <label class="form-label" for="form2Example1">Username</label>
                    <input type="text" id="form2Example1" name="username" class="form-control" required />
                </div>
            </div>

            <!-- Password input -->
            <div class="mb-4">
                <div class="form-outline">
                    <label class="form-label" for="form2Example2">Password</label>
                    <input type="password" id="form2Example2" name="password" class="form-control" />
                </div>
            </div>

            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-4">
                <div class="col d-flex align-items-center">
                    <!-- Checkbox -->
                    <div class="form-check">
                        <input class="form-check-input me-2" type="checkbox" value="" id="form2Example31"
                            checked />
                        <label class="form-check-label" for="form2Example31"> Remember me </label>
                    </div>
                </div>

                <div class="col text-end">
                    <!-- Simple link -->
                    <a href="#" class="text-primary">Forgot password?</a>
                </div>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary w-100">Sign in</button>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>
</body>

</html>
