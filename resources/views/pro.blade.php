@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <!-- Hero -->
        <div class="text-center mb-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">Burner Note Pro</h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                The same zero-knowledge encryption you trust, with audit logs, security policies, and full control.
            </p>
        </div>

        <!-- Value Props -->
        <div class="grid gap-6 mb-12">
            <!-- Audit Trail -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 sm:p-8 transition-colors duration-200">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Complete Audit Trail</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Know exactly what happened to every note you send. Perfect for compliance, or just peace of mind.
                </p>
                <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                    <li>See when each note was viewed or expired</li>
                    <li>Track recipient IP address and device</li>
                    <li>Proof of secure delivery and destruction</li>
                </ul>
            </div>

            <!-- Security Policies -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 sm:p-8 transition-colors duration-200">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Security Policies</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Set rules that are automatically enforced on every note. Never accidentally create a note that doesn't meet your standards.
                </p>
                <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                    <li>Maximum expiry time</li>
                    <li>Required password protection</li>
                    <li>Maximum view limits</li>
                </ul>
            </div>

            <!-- Team Management -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 sm:p-8 transition-colors duration-200">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Invite Your Team</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Share Pro features with colleagues. Everyone works under the same policies with a unified audit log.
                </p>
                <ul class="space-y-2 text-sm text-gray-500 dark:text-gray-400">
                    <li>One-click email invitations</li>
                    <li>Role-based access control</li>
                    <li>Passwordless magic link sign-in</li>
                </ul>
            </div>
        </div>

        <!-- CTA -->
        <div class="bg-gray-900 dark:bg-white rounded-2xl p-8 text-center">
            <h2 class="text-2xl font-bold text-white dark:text-gray-900 mb-3">Ready to go Pro?</h2>
            <p class="text-gray-300 dark:text-gray-600 mb-6">
                Get started in minutes. Free while in beta.
            </p>
            <a href="{{ route('register') }}" class="inline-block px-6 py-3 bg-white dark:bg-gray-900 text-gray-900 dark:text-white font-medium rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                Create Account
            </a>
        </div>

        <!-- Same Security -->
        <div class="mt-12 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Same zero-knowledge encryption. Same open source transparency. Same burn-after-reading guarantee.
            </p>
        </div>
    </div>
@endsection
