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
            <div class="w-full max-w-md bg-white border border-gray-200 rounded-lg shadow sm:p-2 md:p-4 dark:bg-gray-800 dark:border-gray-700">
                <form class="bg-white rounded-xl drop-shadow-lg space-y-3" action="{{ '/update/user/'.$id }}" method="POST">
                    @csrf
                    <h1 class="flex justify-center text-3xl font-semibold text-slate-600">Edit User</h1>
                    @foreach ($edit as $item)
                        <div class="flex flex-wrap flex-col">
                            <div class="px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold" for="grid-first-name">
                                First Name
                                </label>
                                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-first-name" value="{{ $item->fname }}" name="fname" type="text" placeholder="First Name" required>
                            </div>
                            <div class="px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold" for="grid-middle-name">
                                Middle Name
                                </label>
                                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" value="{{ $item->mname }}" name="mname" type="text" placeholder="Middle Name" required>
                            </div>
                            <div class="px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold" for="grid-last-name">
                                Last Name
                                </label>
                                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" value="{{ $item->lname }}" type="text" placeholder="Last Name" name="lname" required>
                            </div> 
                            <div class="px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold" for="grid-last-name">Section</label>
                                <select name="section" id="grid-last-name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="none" disabled selected>{{ $item->section }}</option>
                                    @foreach ($sections as $section)
                                    <option value="{{ $section->id }}" id="">{{ $section->section}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="px-3 mb-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold" id="showOne">Course</label>
                                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" value="{{ $item->course }}" type="text" id="showOne" name="course" placeholder="Course">
                            </div>
                            <div class="px-3 mb-3">
                                <input class="w-full px-10 py-3 bg-blue-600 text-white text-md rounded-md hover:bg-blue-500 hover:drop-shadow-md duration-300 ease-in" type="submit" name="signup" value="Update"></input>
                            </div>
                            <div class="px-3 mb-3">
                                <a href="{{ '/users' }}" class="flex justify-center text-slate-600 font-medium rounded-lg text-md text-center underline">cancel</a>
                            </div>
                        </div>
                        
                    @endforeach
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>
<script>
    
</script>