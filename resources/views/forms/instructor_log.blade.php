@php
    use App\Models\Logs;
    use App\Models\units;
    use Carbon\Carbon;
    function studentPC($s_StartTime, $s_EndTime, $section, $s_Room, $pcnum){

        $date = Carbon::now();
        $ymd = $date = $date->format('Y:m:d');

        $log = Logs::
        where('created_at', '>=', $ymd.' '.$s_StartTime)
        ->where('created_at', '<=', $ymd.' '.$s_EndTime)
        ->where('section', $section)
        ->where('room', $s_Room)
        ->where('pcnum', $pcnum)
        ->first();

        if ( !empty($log) ) {
            return $log->user_id;
        } else {
            return "available";
        }
    }
    function studentTimeIn($s_StartTime, $s_EndTime, $section, $s_Room, $pcnum){

        $date = Carbon::now();
        $ymd = $date = $date->format('Y:m:d');

        $log = Logs::
        where('created_at', '>=', $ymd.' '.$s_StartTime)
        ->where('created_at', '<=', $ymd.' '.$s_EndTime)
        ->where('section', $section)
        ->where('room', $s_Room)
        ->where('pcnum', $pcnum)
        ->first();

        if ( !empty($log) ) {
            return $log->start_time;
        } else {
            return "available";
        }
    }
    function studentTimeOut($s_StartTime, $s_EndTime, $section, $s_Room, $pcnum){
        $date = Carbon::now();
        $ymd = $date = $date->format('Y:m:d');

        $log = Logs::
        where('created_at', '>=', $ymd.' '.$s_StartTime)
        ->where('created_at', '<=', $ymd.' '.$s_EndTime)
        ->where('section', $section)
        ->where('room', $s_Room)
        ->where('pcnum', $pcnum)
        ->first();

        if ( !empty($log) ) {
            return $log->end_time;
        } else {
            return "available";
        }
    }
    function studentFeedBack($s_StartTime, $s_EndTime, $section, $s_Room, $pcnum){
        $date = Carbon::now();
        $ymd = $date = $date->format('Y:m:d');

        $log = Logs::
        where('created_at', '>=', $ymd.' '.$s_StartTime)
        ->where('created_at', '<=', $ymd.' '.$s_EndTime)
        ->where('section', $section)
        ->where('room', $s_Room)
        ->where('pcnum', $pcnum)
        ->first();

        if ( !empty($log) ) {
            return $log->feedback;
        } else {
            return "on going";
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
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://markcell.github.io/jquery-tabledit/assets/js/tabledit.min.js"></script>

        <title>IT Center</title>

    </head>
<body>
    <div>
        <div class="flex justify-center uppercase text-3xl bg-green-700 py-2 text-white font-semibold">
            <h1>You are now time in</h1>
        </div>

        <div class="absolute flex items-center justify-center">
            <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="authentication-modal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="px-6 py-6 lg:px-8">
                            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Edit Unit</h3>
                            <form class="space-y-6" action="{{ route('updateData') }}" method="POST">
                                @csrf
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                    <select name="status" id="" class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white text-slate-600 italic">
                                        <option value="none" disabled selected></option>
                                        <option value="NOT-WORKING">NOT-WORKING</option>
                                        <option value="WORKING">WORKING</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Issue</label>
                                    <input type="text" name="issue" id="" value="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                </div>

                                <input type="hidden" value="" name="pc_id" id="pc_id">
                                
                                <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div> 
        </div>

        {{-- form --}}
        <div class="flex justify-left mx-32 mt-2 space-x-3 ">
            <div class="mb-1">
                <!-- Modal toggle -->
                <button data-modal-target="authentication-modals" data-modal-toggle="authentication-modals" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                    Time Out
                </button>

                <!-- Main modal -->
                <div id="authentication-modals" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="authentication-modals">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>

                            <div class="px-6 py-4 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-base font-semibold text-gray-900 lg:text-xl dark:text-white">
                                    Leave a feedback
                                </h3>
                            </div>
                            <div class="p-6">
                                <form class="" action="{{ '/instructor/timeout' }}" method="post">@csrf
                                    <textarea id="message" name="feedbacks" rows="4" cols="50" class="pl-2 border border-gray-300 rounded-md"></textarea>
                                    {{-- <input type="hidden" value="{{ $proflogs_id }}" name="logid"> --}}
                                    {{-- <input type="hidden" name="rID" value="{{ $roomID }}"> --}}
                                    <div class="flex justify-end">
                                        <input type="submit" value="Logout" name="submit" class="py-1 bg-red-700 w-20 text-white text-md rounded-md hover:bg-red-500 hover:drop-shadow-md duration-300 ease-in mr-1">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end form --}}

        <div class="overflow-x-auto shadow-md sm:rounded-lg mx-32 ">
            <div class="flex items-center justify-center">
                <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 text-left pl-2">Day</th>
                            <th scope="col" class="py-3 text-left pl-2">Start Time</th>
                            <th scope="col" class="py-3 text-left pl-2">Section</th>
                            <th scope="col" class="py-3 text-left pl-2">Subject</th>
                            <th scope="col" class="py-3 text-left pl-2">Room#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-3 text-left pl-2">{{ Session::get('s_Day') }}</td>
                            <td class="py-3 text-left pl-2">{{ Session::get('start_time') }}</td>
                            <td class="py-3 text-left pl-2">{{ Session::get('section_name') }}</td>
                            <td class="py-3 text-left pl-2">{{ Session::get('subject_name') }}</td>
                            <td class="py-3 text-left pl-2">Lab {{ Session::get('s_Room') }}</td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>

        <div class="flex justify-start pl-5 py-2 mt-5 mx-32 bg-green-700">
            {{-- <button id="refresh-btn" class="float-left bg-slate-400 rounded-md p-1">Refresh</button> --}}
            <h1 class="uppercase text-2xl font-semibold text-white pl-96">
                student list
            </h1>
        </div>

        <div class="overflow-x-auto shadow-md sm:rounded-lg mx-32">
            @if (Session::has('success'))
            <div class="flex justify-center mt-2 mb-2 p-2 bg-green-600 text-white">
                {{ session('success') }}
            </div>
            @endif

            <div class="">
                {{-- id="editable" --}}
                <table id="editable" class="text-sm text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 text-left pl-2">PC Number</th>
                            <th scope="col" class="py-3 text-left pl-2">Status</th>
                            <th scope="col" class="py-3 text-left pl-2">Issue</th>
                            <th scope="col" class="py-3 text-left pl-2">Student</th>
                            {{-- <th scope="col" class="py-3 text-left pl-2">Time In</th>
                            <th scope="col" class="py-3 text-left pl-2">Time Out</th>
                            <th scope="col" class="py-3 text-left pl-2">FeedBack</th> --}}
                            <th scope="col" class="py-3 text-left pl-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($units as $unit)

                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <td class="py-3 text-left pl-2">PC {{ $unit->pc_number }}</td>

                                @if ($unit->status == null)

                                    <td class="italic py-3 text-left pl-2">Null</td>

                                @else

                                    <td class="py-3 text-left pl-2">{{ $unit->status }}</td>

                                @endif

                                @if ($unit->issue == null)
                                    <td class="italic py-3 text-left pl-2">Null</td>
                                @else
                                    <td class="py-3 text-left pl-2">{{ $unit->issue }}</td>
                                @endif

                                <td class="py-3 text-left pl-2">{{ studentPC($schedule->start_time, $schedule->end_time, $section_name, $schedule->room, $unit->pc_number) }}</td>
                                {{-- <td class="py-3 text-left pl-2">{{ studentTimeIn($schedule->start_time, $schedule->end_time, $section_name, $schedule->room, $unit->pc_number) }}</td>
                                <td class="py-3 text-left pl-2">{{ studentTimeOut($schedule->start_time, $schedule->end_time, $section_name, $schedule->room, $unit->pc_number) }}</td>
                                <td class="py-3 text-left pl-2">{{ studentFeedBack($schedule->start_time, $schedule->end_time, $section_name, $schedule->room, $unit->pc_number) }}</td> --}}
                                <td class="py-3 text-left pl-2 italic text-blue-800 underline">
                                    <button type="button" data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" name="unitID" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" onclick="getSectionID({{ $unit->id }})">
                                        edit
                                    </button>
                                </td>
                                {{-- modal button --}}
                                
                            </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>


    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>




</body>
</html>
    <script>
        let table = new DataTable('#editable');

        function getSectionID(pc_id){
        
        document.getElementById('pc_id').value = pc_id;

    }
    </script>
    
    {{-- <script type="text/javascript">
        $(document).ready(function(){

            $.ajaxSetup({
            headers:{
                'X-CSRF-Token' : $("input[name=_token]").val()
            }
            });

            $('#editable').Tabledit({
            url:'{{ route("tabledit/actions") }}',
            dataType:"json",
            columns:{
                identifier:[[0, 'id'],[1, 'pc_number']],
                editable:[[2, 'status', '{"1":"WORKING", "2":"NOT-WORKING"}' ], [3, 'issue']]
            },
            restoreButton:false,
            onSuccess:function(data, textStatus, jqXHR)
            {
                if(data.action == 'delete')
                {
                $('#'+data.id).remove();
                }
            }
            });

        });
    </script> --}}
