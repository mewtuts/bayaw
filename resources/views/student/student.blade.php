@php
    use App\Models\Logs;
    use Carbon\Carbon;

    function PCAVAILABLE($STIME, $ETIME, $SEC, $LAB, $pcNum){

        $date = Carbon::now();
        $ymd = $date = $date->format('Y:m:d');

        $log = Logs::
        where('created_at', '>=', $ymd.' '.$STIME)
        ->where('created_at', '<=', $ymd.' '.$ETIME)
        ->where('section', $SEC)
        ->where('room', $LAB)
        ->where('pcnum', $pcNum)
        ->first();

        if ( !empty($log) ) {
            return $log->pcnum;
        } else {
            return "available";
        }
    }

@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

        <title>IT Center</title>

    </head>
    <body class="bg-white drop-shadow-lg">
        {{-- header --}}
        <div class="w-full h-16 bg-green-800 drop-shadow-lg">
            <div class="container px-4 md:px-0 h-full mx-auto flex justify-between items-center">
                <h1 class="text-yellow-500 text-2xl font-bold italic">Welcome <span class="text-white">{{ Session::get('user_firstname') }}</span>
                </h1>
                    <ul id="menu" class="hidden fixed top-0 right-0 px-10 py-16 bg-gray-800 z-50
                    md:relative md:flex md:p-0 md:bg-transparent md:flex-row md:space-x-6">
                    <li class="md:hidden z-90 fixed top-4 right-6">
                        <a href="javascript:void(0)" class="text-right text-white text-4xl"
                            onclick="toggleMenu()">&times;</a>
                    </li>
                </ul>
            </div>
        </div>
        {{-- end of header --}}


        @if ($sec->status == '1')
            <div class="bg-green-600 p-5 text-2xl text-white mt-10 mx-32 rounded-xl text-center">
                <h1>You are allowed to use a laboratory</h1>
            </div>
                <div class="flex justify-center item-center w-screen mt-10">
                    <div class="px-2 py-2 space-x-3 ">
                        <form class="py-3 drop-shadow-sm" action="{{ '/allowed/log' }}" method="post"> @csrf
                            <div class="sm:flex space-x-3">
                                <div class="space-y-2">
                                    <div class="flex justify-center uppercase">
                                        <label for="subj" class="text-lg underline font-semibold"> Subject </label>
                                    </div>
                                    <input type="text" name="subj" value="{{ $subjects }}" readonly id="" class="text-center block p-1 text-lg italic text-gray-500 border border-gray-300 rounded-sm w-60 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                </div>

                                <div class="space-y-2">
                                    <div class="flex justify-center uppercase">
                                        <label for="instruc" class="text-lg underline font-semibold"> Instructor </label>
                                    </div>
                                    <input type="text" value="{{ $profesor }}" name="instruc" readonly id="" class="text-center block p-1 text-lg italic text-gray-500 border border-gray-300 rounded-sm w-60 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                </div>

                                <div class="space-y-2">
                                    <div class="flex justify-center uppercase">
                                        <label for="labnum" class="text-lg underline font-semibold"> laboratory </label>
                                    </div>
                                    <input type="text" value="{{ $rom->room }}" name="labnum" readonly class="text-center block p-1 text-lg italic text-gray-500 border border-gray-300 rounded-sm w-60 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                </div>
                            </div>

                            {{-- <input type="number" placeholder="Input PC Number" name="pcnum" class="italic text-center block text-sm text-gray-500 border border-gray-300 rounded-sm w-60 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required> --}}
                            <div class="flex justify-center space-x-2 mt-10">
                                <select name="pcnum" id="mySelect" class="text-center block p-2 text-xl text-gray-900 border border-gray-300 rounded-sm w-60 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="none" selected disabled>Select unit</option>
                                    @foreach ($pcs as $item)
                                        <option value="{{ $item->id }}">PC {{ $item->pc_number }}</option>
                                    @endforeach
                                </select>

                                <input type="hidden" name="rid" value="{{ $rid }}">
                                <input type="hidden" name="sid" value="{{ $sid }}">
                                <input type="hidden" name="secID" value="{{ $secID }}">
                                <input type="submit" name="submit" class="bg-blue-600 w-24 text-white text-sm rounded-sm hover:bg-blue-500 hover:drop-shadow-md duration-300" value="TIME IN" >
                            </div>
                        </form>
                    </div>
                </div>
                @elseif (count($schedule) === 0)
                    <div class="bg-red-500 p-5 text-2xl text-white mt-10 mx-32 rounded-xl text-center">
                        <h1>You don't have schedule at the moment</h1>
                    </div>
                    @else
                    <div class="flex justify-center mt-5 text-2xl text-black">
                        <h1 class="uppercase underline font-bold">My schedule</h1>
                    </div>
                    {{-- form ng select pc--}}
                    <div class="flex justify-left mx-32 mt-5">
                        <div class="mb-3 spspace-y-3">
                            <form class="sm:flex flex-row-reverse" action="{{ route('log') }}" method="post"> @csrf

                                <select name="pcnum" class="block text-center py-1 text-md text-gray-900 border border-gray-300 rounded-lg w-40 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>

                                    <option value="none" disabled>Available units</option>

                                    @if (count($unit) === 1)

                                    @else

                                        @foreach ($unit as $item)

                                            @if (PCAVAILABLE($STIME, $ETIME, $SEC, $LAB, $item->pc_number) == 'available')

                                                <option value="{{ $item->pc_number }}">PC {{ $item->pc_number }}</option>

                                            @endif

                                        @endforeach

                                    @endif

                                </select>

                                <input type="hidden" name="rid" value="{{ $rid }}">
                                <input type="hidden" name="sid" value="{{ $sid }}">

                                <input type="submit" name="submit" class="w-40 px-10 py-1 bg-blue-600 text-white text-lg rounded-md hover:bg-blue-500 hover:drop-shadow-md duration-300 ease-in mr-1" value="TIME IN">

                            </form>
                        </div>
                    </div>
                    {{-- end form ng select pc --}}
                    <div class="flex justify-center text-center mx-32">
                        <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 text-left pl-2">Day</th>
                                    <th scope="col" class="py-3 text-left pl-2">Start Time</th>
                                    <th scope="col" class="py-3 text-left pl-2">End Time</th>
                                    <th scope="col" class="py-3 text-left pl-2">Room#</th>
                                    <th scope="col" class="py-3 text-left pl-2">Instructor</th>
                                </tr>
                            </thead>
                            <tbody id="myTable">
                                @foreach ($schedule as $item)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="py-3 text-left pl-2">{{ $item->day }}</td>
                                        <td class="py-3 text-left pl-2">{{ $item->start_time }}</td>
                                        <td class="py-3 text-left pl-2">{{ $item->end_time }}</td>
                                        <td class="py-3 text-left pl-2">Lab {{ $item->room }}</td>
                                        <td class="py-3 text-left pl-2">{{ $item->fname.' '. $item->lname }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

            @endif
        {{-- @if (count($schedule) === 0)
            <div class="bg-red-500 p-5 text-2xl text-white mt-10 mx-32 rounded-xl text-center">
                <h1>You don't have schedule at the moment</h1>
            </div>


            admin allow you to time in
            <div class="flex justify-center w-screen mt-10">
                <div class="p-3 space-y-3">
                    <form class="p-3 bg-green-700 rounded-xl drop-shadow-lg space-y-3" action="{{ route('log') }}" method="post"> @csrf
                        <select name="pcnum" id="" class="text-center block p-2 text-xl text-gray-900 border border-gray-300 rounded-lg w-60 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="none" selected disabled>Select unit</option>
                            @if (count($unit) === 1)
                                <option value="none">None</option>
                            @else
                                @foreach ($unit as $item)
                                <option value="{{ $item->pc_number }}">{{ $item->pc_number }}</option>
                                @endforeach
                            @endif
                        </select>
                        <input type="hidden" name="rid" value="{{ $rid }}">
                        <input type="hidden" name="sid" value="{{ $sid }}">
                        <input type="submit" name="submit" class="w-full px-10 py-3 bg-blue-600 text-white text-lg rounded-md hover:bg-blue-500 hover:drop-shadow-md duration-300 ease-in" value="TIME IN" >

                    </form>
                </div>
            </div>

            @endif

            @else
            <div class="flex justify-center p-5 text-2xl text-black">
                <h1 class="mb-4 uppercase underline font-bold">My schedule</h1>
            </div>
            <div class="flex justify-center text-center mx-32">
                <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 text-left pl-2">Day</th>
                            <th scope="col" class="py-3 text-left pl-2">Start Time</th>
                            <th scope="col" class="py-3 text-left pl-2">End Time</th>
                            <th scope="col" class="py-3 text-left pl-2">Room#</th>
                            <th scope="col" class="py-3 text-left pl-2">Instructor</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        @foreach ($schedule as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="py-3 text-left pl-2">{{ $item->day }}</td>
                                <td class="py-3 text-left pl-2">{{ $item->start_time }}</td>
                                <td class="py-3 text-left pl-2">{{ $item->end_time }}</td>
                                <td class="py-3 text-left pl-2">Lab {{ $item->room }}</td>
                                <td class="py-3 text-left pl-2">{{ $item->fname.' '. $item->lname }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="flex justify-center w-screen mt-10">
                <div class="p-3 space-y-3">
                    <form class="p-3 bg-green-700 rounded-xl drop-shadow-lg space-y-3" action="{{ route('log') }}" method="post"> @csrf
                        <select name="pcnum" id="" class="text-center block p-2 text-xl text-gray-900 border border-gray-300 rounded-lg w-60 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="none" selected disabled>Select unit</option>
                            @if (count($unit) === 1)
                                <option value="none">None</option>
                            @else
                                @foreach ($unit as $item)
                                <option value="{{ $item->pc_number }}">{{ $item->pc_number }}</option>
                                @endforeach
                            @endif
                        </select>
                        <input type="hidden" name="rid" value="{{ $rid }}">
                        <input type="hidden" name="sid" value="{{ $sid }}">
                        <input type="submit" name="submit" class="w-full px-10 py-3 bg-blue-600 text-white text-lg rounded-md hover:bg-blue-500 hover:drop-shadow-md duration-300 ease-in" value="TIME IN" >

                    </form>
                </div>
            </div>
        @endif --}}





    </body>
</html>
<script>
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    $(document).ready(function($) {
        $('#filter').change(function() {
            var value = $(this).val().toLowerCase();
            $("#mySelect").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });

        });
    })

    function filterSelect() {
    var input = document.getElementById("searchInput");
    var filter = input.value.toUpperCase();
    var select = document.getElementById("mySelect");
    var options = select.options;
    for (var i = 0; i < options.length; i++) {
        var txtValue = options[i].text.toUpperCase();
        if (txtValue.indexOf(filter) > -1) {
        options[i].style.display = "";
        } else {
        options[i].style.display = "none";
        }
    }
    }
</script>
