<template x-if="currentUserId != message.user_id">
    <div class="col-start-1 col-end-8 p-3 rounded-lg">
        <div class="flex flex-row items-center">
        <div x-text="message.avatar"
            class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0"
        >
        </div>
        <div
            class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl"
        >
            <div x-text="message.content" ></div>
        </div>
        </div>
    </div>
</template>
<template x-if="currentUserId == message.user_id">
    <div class="col-start-6 col-end-13 p-3 rounded-lg">
        <div class="flex items-center justify-start flex-row-reverse">
        <div x-text="message.avatar"
            class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0"
        ></div>
        <div
            class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl"
        >
            <div x-text="message.content"></div>
            {{-- <div
                class="absolute text-xs bottom-0 right-0 -mb-5 mr-2 text-gray-500"
            >
                Seen
            </div> --}}
        </div>
        </div>
    </div>
</template>
