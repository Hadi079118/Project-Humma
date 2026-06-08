<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SYSTEM LOCK - RETRO PS RENTAL</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-retro-bg flex items-center justify-center font-sans text-slate-100 p-4">

    <div class="max-w-md w-full">
        <!-- Brand Header -->
        <div class="text-center mb-8">
            <h1 class="font-retro text-2xl text-retro-cyan glow-cyan tracking-widest leading-relaxed">
                RETRO PS
            </h1>
            <p class="font-retro text-xs text-retro-pink glow-pink tracking-widest mt-2">
                [SYSTEM GATEWAY]
            </p>
        </div>

        <!-- Login Card -->
        <div class="retro-card p-8 rounded-lg border-l-retro-cyan">
            <div class="text-center mb-6">
                <span class="inline-block px-3 py-1 bg-purple-950 text-retro-yellow text-xs font-retro tracking-widest animate-pulse" style="font-size: 0.6rem;">
                    INSERT CREDENTIALS TO BOOT
                </span>
            </div>

            <!-- Error Notifications -->
            @if($errors->any())
                <div class="mb-6 p-3 bg-rose-950/80 border border-retro-pink text-retro-pink rounded text-xs">
                    <span class="font-retro inline-block mb-1" style="font-size: 0.55rem;">[BOOT FAILURE]</span>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 p-3 bg-emerald-950/85 border border-retro-green text-retro-green rounded text-xs">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.60rem;">
                        [STAFF EMAIL]
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded px-4 py-3 text-sm focus:outline-none transition-colors duration-100 placeholder-purple-900"
                           placeholder="staff@retro.com">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-retro text-retro-cyan uppercase tracking-wider mb-2" style="font-size: 0.60rem;">
                        [ACCESS CODE]
                    </label>
                    <input type="password" name="password" id="password" required
                           class="w-full bg-retro-bg border-2 border-purple-900 focus:border-retro-cyan rounded px-4 py-3 text-sm focus:outline-none transition-colors duration-100 placeholder-purple-900"
                           placeholder="••••••••">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-retro-bg border-purple-900 text-retro-cyan focus:ring-0">
                        <span class="ml-2 text-xs text-gray-400">Remember session</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="btn-cross w-full py-3 rounded font-retro text-xs tracking-widest cursor-pointer transition-all duration-100 flex items-center justify-center space-x-2 shadow-[0_0_10px_rgba(0,240,255,0.2)]">
                        <span>✖ RUN BOOT SEQUENCE</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Info -->
        <div class="text-center mt-6 text-gray-600 text-xs">
            <p>Seeded Credentials:</p>
            <p class="mt-1">Admin: <span class="text-retro-cyan">admin@retro.com</span> | Pass: <span class="text-retro-yellow">admin123</span></p>
            <p>Staff: <span class="text-retro-pink">staff@retro.com</span> | Pass: <span class="text-retro-yellow">staff123</span></p>
        </div>
    </div>

</body>
</html>
