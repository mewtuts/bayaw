<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.css" rel="stylesheet" />
    @vite('resources/css/app.css')
    <title>Form</title>
</head>
<body>
    <div class="h-screen w-screen bg-slate-400">
        <div class="h-full w-full flex justify-center items-center">
            <div class="w-full max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
                <form class="space-y-3" action="{{ '/edit_unit/'.$roomID.'/'.$pcid}}" method="post">
                    @csrf
                    <h5 class="text-xl flex justify-center font-medium text-gray-900 dark:text-white">Update</h5>
                    <div>
                        <label for="status" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">STATUS</label>
                        <select name="status" id="" class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white text-slate-600 italic">
                            <option value="none" disabled selected>{{ $pc->status }}</option>
                            <option value="NOT-WORKING">NOT-WORKING</option>
                            <option value="WORKING">WORKING</option>
                        </select>
                        
                    </div>
                    <div>
                        <label for="issue" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">ISSUE</label>
                        <input type="text" name="issue" id="" value="{{ $pc->issue }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                    </div>
                    
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
                    <a href="{{ '/instructor/dashboard' }}" class="flex justify-center text-slate-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center underline">Cancel</a>
                    
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>
<script>
    document.getElemensByName('status')[0].value = "{{ $pc->status }}";
</script>