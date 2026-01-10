@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="mb-8">
            <a href="{{ route('teams.show', $team) }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 text-sm">&larr; Back to {{ $team->name }}</a>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-2">Manage Members</h1>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl">
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                <p class="text-sm text-red-600 dark:text-red-400">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Invite Member -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 mb-6 transition-colors duration-200">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Invite Member</h2>
            <form method="POST" action="{{ route('teams.invite', $team) }}" class="flex gap-3">
                @csrf
                <input
                    type="email"
                    name="email"
                    required
                    placeholder="colleague@company.com"
                    class="flex-1 px-4 py-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200 placeholder:text-gray-400 dark:placeholder:text-gray-500"
                >
                <select name="role" class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white">
                    <option value="member">Member</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-medium rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors">
                    Invite
                </button>
            </form>
            @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Current Members -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 mb-6 transition-colors duration-200">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Members</h2>
            <div class="space-y-4">
                @foreach($team->members as $member)
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div>
                            <p class="text-gray-900 dark:text-white">{{ $member->email }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 capitalize">
                                {{ $member->pivot->role }}
                            </span>
                            @if($member->pivot->role !== 'owner' && $team->isOwner(Auth::user()))
                                <form method="POST" action="{{ route('teams.members.remove', [$team, $member]) }}" onsubmit="return confirm('Remove this member?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Remove</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Pending Invitations -->
        @if($team->invitations->isNotEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 transition-colors duration-200">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pending Invitations</h2>
                <div class="space-y-4">
                    @foreach($team->invitations as $invitation)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                            <div>
                                <p class="text-gray-900 dark:text-white">{{ $invitation->email }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Invited as {{ $invitation->role }} · Expires {{ $invitation->expires_at->diffForHumans() }}
                                </p>
                            </div>
                            <form method="POST" action="{{ route('teams.invitations.cancel', [$team, $invitation]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-sm">Cancel</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
