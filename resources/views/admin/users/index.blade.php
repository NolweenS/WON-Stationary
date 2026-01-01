<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            {{-- Header tekst in donkerbruin --}}
            <h2 class="font-semibold text-xl text-[#3E2723] leading-tight">
                User Management
            </h2>
            {{-- Primaire knop: Chocoladebruin --}}
            <a href="{{ route('admin.users.create') }}" class="bg-[#5D4037] text-white px-4 py-2 rounded-md hover:bg-[#4E342E] transition duration-150 ease-in-out text-sm shadow-sm">
                + Nieuwe Gebruiker
            </a>
        </div>
    </x-slot>

    {{-- Achtergrond van de pagina container iets warmer maken als je wilt, anders standaard --}}
    <div class="py-12 bg-[#FDFBF7]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- STATS CARDS: Randkleuren aangepast naar Aardetinten --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded shadow-sm border-l-4 border-[#5D4037]">
                    <div class="text-[#8D6E63] text-sm font-medium">Totaal Users</div>
                    <div class="text-2xl font-bold text-[#3E2723]">{{ $stats['total_users'] }}</div>
                </div>
                <div class="bg-white p-4 rounded shadow-sm border-l-4 border-[#8D6E63]">
                    <div class="text-[#8D6E63] text-sm font-medium">Admins</div>
                    <div class="text-2xl font-bold text-[#3E2723]">{{ $stats['admin_count'] }}</div>
                </div>
                <div class="bg-white p-4 rounded shadow-sm border-l-4 border-[#A1887F]">
                    <div class="text-[#8D6E63] text-sm font-medium">Klanten</div>
                    <div class="text-2xl font-bold text-[#3E2723]">{{ $stats['regular_users'] }}</div>
                </div>
                <div class="bg-white p-4 rounded shadow-sm border-l-4 border-[#D7CCC8]">
                    <div class="text-[#8D6E63] text-sm font-medium">Nieuw (30d)</div>
                    <div class="text-2xl font-bold text-[#3E2723]">{{ $stats['recent_users'] }}</div>
                </div>
            </div>

            {{-- NOTIFICATIES: Kleuren iets gedempt --}}
            @if(session('success'))
                <div class="bg-[#E8F5E9] text-[#1B5E20] border border-[#C8E6C9] p-4 rounded mb-4 text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-[#FFEBEE] text-[#B71C1C] border border-[#FFCDD2] p-4 rounded mb-4 text-sm">{{ session('error') }}</div>
            @endif

            {{-- TABEL CONTAINER --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-[#EFEBE9]">
                <table class="w-full text-left border-collapse">
                    {{-- Tabel Header: Licht beige achtergrond --}}
                    <thead class="bg-[#F8F5F2] border-b border-[#D7CCC8]">
                    <tr>
                        <th class="p-4 font-semibold text-[#5D4037]">Naam</th>
                        <th class="p-4 font-semibold text-[#5D4037]">Email</th>
                        <th class="p-4 font-semibold text-[#5D4037]">Rol</th>
                        <th class="p-4 font-semibold text-[#5D4037]">Geregistreerd</th>
                        <th class="p-4 font-semibold text-[#5D4037] text-right">Acties</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EFEBE9]">
                    @foreach($users as $user)
                        {{-- Hover: Heel licht crème --}}
                        <tr class="hover:bg-[#FAF9F6] transition-colors">
                            <td class="p-4 font-medium text-[#3E2723]">{{ $user->name }}</td>
                            <td class="p-4 text-[#5D4037]">{{ $user->email }}</td>
                            <td class="p-4">
                                @if($user->is_admin)
                                    {{-- Admin Badge: Donker --}}
                                    <span class="bg-[#4E342E] text-white text-xs px-2 py-1 rounded-md font-medium">Admin</span>
                                @else
                                    {{-- Klant Badge: Zandkleur --}}
                                    <span class="bg-[#EFEBE9] text-[#5D4037] text-xs px-2 py-1 rounded-md font-medium">Klant</span>
                                @endif
                            </td>
                            <td class="p-4 text-[#8D6E63] text-sm">{{ $user->created_at->format('d-m-Y') }}</td>
                            <td class="p-4 flex justify-end gap-3 items-center">

                                @if($user->is_admin)
                                    <form action="{{ route('admin.users.demote', $user) }}" method="POST">
                                        @csrf @method('PATCH')
                                        {{-- Demote knop: Subtiel bruin --}}
                                        <button type="submit" class="text-[#8D6E63] hover:text-[#5D4037] text-sm font-medium transition-colors" title="Degraderen">
                                            ▼ User
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.users.promote', $user) }}" method="POST">
                                        @csrf @method('PATCH')
                                        {{-- Promote knop: Primaire bruine kleur --}}
                                        <button type="submit" class="text-[#5D4037] hover:text-[#3E2723] text-sm font-bold transition-colors" title="Promoveren">
                                            ▲ Admin
                                        </button>
                                    </form>
                                @endif

                                <span class="text-[#D7CCC8]">|</span>

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?');">
                                    @csrf @method('DELETE')
                                    {{-- Delete knop: Rood behouden voor waarschuwing, maar iets dieper --}}
                                    <button type="submit" class="text-[#C62828] hover:text-[#B71C1C] text-sm transition-colors">
                                        Verwijder
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{-- Paginering (Zorg dat je pagination views ook gestyled zijn of standaard blijven) --}}
                <div class="p-4 bg-white border-t border-[#EFEBE9]">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
