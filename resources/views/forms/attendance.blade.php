<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
        
        <title>IT Center</title>
    </head>
    <body class="bg-white drop-shadow-lg">
        {{-- title --}}
            
        {{-- end title --}}

        {{-- table --}}
        <div class="h-screen flex justify-center items-center">
            <div class="w-jomar px-3">
                <div class="w-teria min-w-full md:min-w-0text-sm shadow-lg sm:rounded-lg overflow-y-auto h-teria">
                    {{-- @if(session::has('success'))
                        <div class="flex justify-center p-5 bg-red-600 text-white">
                            {{ session('success') }}
                        </div>
                        @elseif(session::has('updated'))
                        <div class="flex justify-center p-5 bg-green-600 text-white">
                            {{ session('updated') }}
                        </div>
                    @endif --}}
                    <a href="{{ '/instructor/timein' }}" class="bg-green-700 mb-5 flex justify-center text-white rounded-md text-4xl font-bold italic">attendance</a>
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 text-left pl-2">
                                    Name
                                </th>   
                                <th scope="col" class="py-3 text-left pl-2">
                                    PC #
                                </th>
                                <th scope="col" class="py-3 text-left pl-2">
                                    Time In
                                </th>
                                <th scope="col" class="py-3 text-left pl-2">
                                    Time out
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendance as $unit)
                                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                    
                                    <td class="py-3 pl-2">
                                        {{ $unit->user_id }}
                                    </td>
                                    <td class="py-3 pl-2">
                                        {{ $unit->pcnum }}
                                    </td>
                                    <td class="py-3 pl-2">
                                        {{ $unit->start_time }}
                                    </td>
                                    <td class="py-3 pl-2">
                                        {{ $unit->end_time }}
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- end of table --}}
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>

    </body>
</html>

<script>
    var menu = document.getElementById('menu');
    function toggleMenu() {
        menu.classList.toggle('hidden');
        menu.classList.toggle('w-full');
        menu.classList.toggle('h-screen');
    }

    $(document).ready(function(){
        $('#status').on('change', function(){
            var demovalue = $(this).val(); 
            $("div.course_container1").hide();
            $("div.course_container2").hide();
            $("div.section_container1").hide();
            $("div.section_container2").hide();
            $("#showOne"+demovalue).show();
            $("#show2"+demovalue).show();   
            $("#display1"+demovalue).show();
            $("#display2"+demovalue).show();
        });
    });
</script>
