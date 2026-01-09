@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Privacy & Terms</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Last updated: January 2026</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 sm:p-8 space-y-8 transition-colors duration-200">
            <!-- TL;DR -->
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">TL;DR</h2>
                <ul class="space-y-3 text-gray-600 dark:text-gray-400">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span><strong class="text-gray-900 dark:text-white">Anonymous notes:</strong> Zero tracking. Zero logging. We store only encrypted ciphertext we cannot decrypt.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span><strong class="text-gray-900 dark:text-white">Team/account notes:</strong> Opt-in audit logging for compliance. Owner-deletable.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>No ads. No third-party trackers. No data sales. Ever.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Open source. Verify everything yourself.</span>
                    </li>
                </ul>
            </div>

            <!-- Two Privacy Models -->
            <div class="border-t border-gray-100 dark:border-gray-700 pt-6 space-y-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Two Privacy Models</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Burner Note operates under two distinct privacy models depending on how you use the service. This is by design: anonymous users get maximum privacy, while teams get the audit capabilities they need for compliance.
                </p>

                <!-- Anonymous Notes -->
                <div class="bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl p-5">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Anonymous Notes (No Account)
                    </h3>
                    <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                        <p><strong>What we store:</strong></p>
                        <ul class="list-disc list-inside space-y-1 ml-2">
                            <li>Encrypted ciphertext (which we cannot decrypt &mdash; see <a href="/about" class="underline">About</a> for technical details)</li>
                            <li>A random token for URL generation</li>
                            <li>Expiry timestamp</li>
                            <li>View count (integer only)</li>
                            <li>Password hash (if you set one)</li>
                        </ul>
                        <p class="pt-2"><strong>What we do NOT store:</strong></p>
                        <ul class="list-disc list-inside space-y-1 ml-2">
                            <li>Your IP address</li>
                            <li>User agent / browser fingerprint</li>
                            <li>Referrer headers</li>
                            <li>Any identifier linking notes to you</li>
                            <li>Access timestamps beyond "viewed" status</li>
                            <li>The decryption key (exists only in URL fragment)</li>
                        </ul>
                        <p class="pt-2 font-medium">
                            Anonymous notes are cryptographically unlinkable to their creator. We have no mechanism to identify who created a note or correlate multiple notes to the same person.
                        </p>
                    </div>
                </div>

                <!-- Team/Account Notes -->
                <div class="bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl p-5">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Team & Account Notes (Authenticated)
                    </h3>
                    <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                        <p>
                            When you create an account or join a team, you <strong>opt in</strong> to additional data collection for audit and compliance purposes. This is a deliberate trade-off: teams often have regulatory requirements (SOC 2, HIPAA, internal policy) that mandate activity logging.
                        </p>
                        <p><strong>Additional data collected for team notes:</strong></p>
                        <ul class="list-disc list-inside space-y-1 ml-2">
                            <li>User ID of note creator</li>
                            <li>Team association</li>
                            <li>Audit log entries (who created/viewed, when)</li>
                            <li>IP address and user agent (for audit log only)</li>
                            <li>Read receipt metadata (if enabled)</li>
                        </ul>
                        <p class="pt-2"><strong>Important distinctions:</strong></p>
                        <ul class="list-disc list-inside space-y-1 ml-2">
                            <li>Note content remains end-to-end encrypted &mdash; audit logs track <em>activity</em>, not content</li>
                            <li>Audit data is scoped to your team; we don't aggregate across teams</li>
                            <li>Team owners can permanently delete all audit logs at any time</li>
                            <li>You can always create anonymous notes by logging out</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Data We Collect -->
            <div class="border-t border-gray-100 dark:border-gray-700 pt-6 space-y-4 text-gray-600 dark:text-gray-400 leading-relaxed">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Data We Collect</h2>

                <h3 class="text-md font-semibold text-gray-900 dark:text-white pt-2">Analytics</h3>
                <p>
                    We use <a href="https://plausible.io" target="_blank" class="text-gray-900 dark:text-white underline hover:text-gray-700 dark:hover:text-gray-300">Plausible Analytics</a>, a privacy-focused, cookie-free analytics service. Plausible collects:
                </p>
                <ul class="list-disc list-inside space-y-1 ml-2">
                    <li>Page URL (without query strings or fragments)</li>
                    <li>Referrer (previous page)</li>
                    <li>Browser and OS (from User-Agent)</li>
                    <li>Device type (desktop/mobile)</li>
                    <li>Country (from anonymized IP &mdash; IP is discarded, not stored)</li>
                </ul>
                <p>
                    Plausible does not use cookies, does not track users across sites, and is GDPR/CCPA compliant by design. No personal data is collected or stored.
                </p>

                <h3 class="text-md font-semibold text-gray-900 dark:text-white pt-4">Account Data</h3>
                <p>
                    If you create an account, we store:
                </p>
                <ul class="list-disc list-inside space-y-1 ml-2">
                    <li>Email address (for authentication and notifications)</li>
                    <li>Display name (optional)</li>
                    <li>Team memberships and roles</li>
                    <li>Magic link tokens (temporary, 15-minute expiry)</li>
                </ul>
                <p>
                    We use passwordless authentication exclusively. We never store passwords for user accounts.
                </p>

                <h3 class="text-md font-semibold text-gray-900 dark:text-white pt-4">Server Logs</h3>
                <p>
                    Our web server generates standard access logs for operational purposes. These logs:
                </p>
                <ul class="list-disc list-inside space-y-1 ml-2">
                    <li>Contain IP addresses and request paths</li>
                    <li>Are retained for 14 days maximum</li>
                    <li>Are used only for debugging and abuse prevention</li>
                    <li>Are not correlated with note content or user accounts</li>
                </ul>
            </div>

            <!-- What We Don't Do -->
            <div class="border-t border-gray-100 dark:border-gray-700 pt-6 space-y-4 text-gray-600 dark:text-gray-400 leading-relaxed">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">What We Don't Do</h2>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span><strong class="text-gray-900 dark:text-white">Sell data:</strong> We have no advertising or data broker relationships. Your data is not a product.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span><strong class="text-gray-900 dark:text-white">Third-party trackers:</strong> No Google Analytics, Facebook Pixel, or any tracking scripts beyond Plausible.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span><strong class="text-gray-900 dark:text-white">Read your notes:</strong> Cryptographically impossible. The decryption key never reaches our servers.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span><strong class="text-gray-900 dark:text-white">Retain deleted notes:</strong> When a note is deleted, the <code class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded text-gray-800 dark:text-gray-200">DELETE</code> is synchronous and permanent. No soft deletes, no backups of content.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span><strong class="text-gray-900 dark:text-white">Share with law enforcement:</strong> We cannot produce what we don't have. Encrypted ciphertext without keys is useless.</span>
                    </li>
                </ul>
            </div>

            <!-- Data Retention & Deletion -->
            <div class="border-t border-gray-100 dark:border-gray-700 pt-6 space-y-4 text-gray-600 dark:text-gray-400 leading-relaxed">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Data Retention & Deletion</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="text-left py-2 pr-4 font-semibold text-gray-900 dark:text-white">Data Type</th>
                                <th class="text-left py-2 font-semibold text-gray-900 dark:text-white">Retention</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            <tr>
                                <td class="py-2 pr-4">Anonymous note ciphertext</td>
                                <td class="py-2">Until viewed (max views) or expiry date, whichever comes first</td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4">Team note ciphertext</td>
                                <td class="py-2">Same as anonymous &mdash; content deletion is immediate</td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4">Team audit logs</td>
                                <td class="py-2">Until deleted by team owner (self-service)</td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4">User accounts</td>
                                <td class="py-2">Until you request deletion</td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4">Server access logs</td>
                                <td class="py-2">14 days, auto-rotated</td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4">Magic link tokens</td>
                                <td class="py-2">15 minutes (auto-expire)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p>
                    To delete your account and all associated data, contact us at <a href="/contact" class="text-gray-900 dark:text-white underline hover:text-gray-700 dark:hover:text-gray-300">the contact page</a>. Account deletion is permanent and includes removal from all teams.
                </p>
            </div>

            <!-- Terms of Use -->
            <div class="border-t border-gray-100 dark:border-gray-700 pt-6 space-y-4 text-gray-600 dark:text-gray-400 leading-relaxed">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Terms of Use</h2>

                <h3 class="text-md font-semibold text-gray-900 dark:text-white pt-2">Acceptable Use</h3>
                <p>
                    Burner Note is provided for legitimate private communication. You agree not to use the service for:
                </p>
                <ul class="list-disc list-inside space-y-1 ml-2">
                    <li>Distribution of malware or phishing links</li>
                    <li>Harassment, threats, or illegal content</li>
                    <li>Spam or automated abuse</li>
                    <li>Any activity that violates applicable law</li>
                </ul>
                <p>
                    We reserve the right to implement rate limiting and block abusive traffic patterns. Because we cannot read note contents, enforcement is limited to network-level patterns.
                </p>

                <h3 class="text-md font-semibold text-gray-900 dark:text-white pt-4">No Warranty</h3>
                <p>
                    Burner Note is provided "as is" without warranty of any kind. While we implement strong security practices, no system is perfectly secure. We are not liable for:
                </p>
                <ul class="list-disc list-inside space-y-1 ml-2">
                    <li>Data loss due to technical failures</li>
                    <li>Security breaches beyond our reasonable control</li>
                    <li>Misuse of shared note links by recipients</li>
                    <li>Client-side vulnerabilities (compromised devices, malicious extensions)</li>
                </ul>

                <h3 class="text-md font-semibold text-gray-900 dark:text-white pt-4">Service Availability</h3>
                <p>
                    We aim for high availability but do not guarantee uptime. Notes may be deleted if they expire while the service is unavailable. We may modify or discontinue the service at any time.
                </p>
            </div>

            <!-- Legal Requests -->
            <div class="border-t border-gray-100 dark:border-gray-700 pt-6 space-y-4 text-gray-600 dark:text-gray-400 leading-relaxed">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Legal Requests & Transparency</h2>
                <p>
                    If we receive a valid legal request (subpoena, court order, etc.), our response is constrained by what data we actually possess:
                </p>
                <div class="bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl p-5">
                    <p class="font-medium text-gray-900 dark:text-white mb-2">For anonymous notes:</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        We can only provide encrypted ciphertext (useless without the key), the random URL token, and basic metadata (expiry date, view count). We cannot identify the creator or provide decrypted content.
                    </p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl p-5 mt-4">
                    <p class="font-medium text-gray-900 dark:text-white mb-2">For team notes:</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        We can provide audit logs (activity metadata) and account information for the relevant team. Note content remains encrypted and unreadable. We will notify affected users unless legally prohibited.
                    </p>
                </div>
                <p>
                    We will challenge overbroad requests and publish a transparency report if we receive significant law enforcement interest.
                </p>
            </div>

            <!-- Open Source -->
            <div class="border-t border-gray-100 dark:border-gray-700 pt-6 space-y-4 text-gray-600 dark:text-gray-400 leading-relaxed">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Verify It Yourself</h2>
                <p>
                    This document describes our practices, but you don't have to take our word for it. Burner Note is <a href="https://github.com/GigaMick/burnernote" target="_blank" class="text-gray-900 dark:text-white underline hover:text-gray-700 dark:hover:text-gray-300">fully open source</a>.
                </p>
                <p>
                    Relevant files for privacy verification:
                </p>
                <ul class="list-disc list-inside space-y-1 ml-2 font-mono text-sm">
                    <li><code class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded">welcome.blade.php</code> &mdash; client-side encryption implementation</li>
                    <li><code class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded">note-encrypted.blade.php</code> &mdash; client-side decryption</li>
                    <li><code class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded">NoteController.php</code> &mdash; server-side note handling</li>
                    <li><code class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded">TeamAuditLog.php</code> &mdash; audit logging model</li>
                    <li><code class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded">layouts/app.blade.php</code> &mdash; analytics script (Plausible only)</li>
                </ul>
                <p class="pt-2 font-medium text-gray-900 dark:text-white">
                    If our code doesn't match this policy, the code is the source of truth. File an issue.
                </p>
            </div>

            <!-- Contact -->
            <div class="border-t border-gray-100 dark:border-gray-700 pt-6 space-y-4 text-gray-600 dark:text-gray-400 leading-relaxed">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Contact</h2>
                <p>
                    Questions about this policy? <a href="/contact" class="text-gray-900 dark:text-white underline hover:text-gray-700 dark:hover:text-gray-300">Contact us</a>.
                </p>
                <p>
                    We'll update this page when practices change. Material changes will be announced.
                </p>
            </div>
        </div>
    </div>
@endsection
