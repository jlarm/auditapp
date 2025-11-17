<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover, user-scalable=no">

    <title>ARMP Audits</title>

    <link rel="icon" href="/icon.png" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="nativephp-safe-area flex flex-col h-dvh overflow-hidden">
    <!-- Header -->
    <header class="bg-white border-b border-zinc-200 pt-[var(--inset-top)] pl-[var(--inset-left)] pr-[var(--inset-right)]">
        <div class="flex items-center justify-between px-4 py-3">
            <flux:heading size="lg">ARMP Audits</flux:heading>
            <div class="flex items-center gap-2">
                <flux:dropdown position="bottom" align="end">
                    <flux:button icon="ellipsis-horizontal"></flux:button>

                    <flux:navmenu>
                        <flux:navmenu.item href="#" icon="user">Account</flux:navmenu.item>
                        <flux:navmenu.item href="#" icon="building-storefront">Profile</flux:navmenu.item>
                        <flux:navmenu.item href="#" icon="credit-card">Billing</flux:navmenu.item>
                        <flux:navmenu.item href="#" icon="arrow-right-start-on-rectangle">Logout</flux:navmenu.item>
                        <flux:navmenu.item href="#" icon="trash" variant="danger">Delete</flux:navmenu.item>
                        <livewire:logout />
                    </flux:navmenu>
                </flux:dropdown>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto px-4 pb-[var(--inset-bottom)]">
        <div class="py-3">
            {{ $slot }}
        </div>
    </main>

@fluxScripts
</body>
</html>
