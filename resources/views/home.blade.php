@extends('layouts.default')

@section('content')

<!-- component -->
<div x-data="chat" class="flex h-screen antialiased text-gray-800">
    <div class="flex flex-row h-full w-full overflow-x-hidden">
      <div class="flex flex-col py-8 pl-6 pr-2 w-64 bg-white flex-shrink-0">
        <div class="flex flex-row items-center justify-center h-12 w-full">
          <div
            class="flex items-center justify-center rounded-2xl text-indigo-700 bg-indigo-100 h-10 w-10"
          >
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
              ></path>
            </svg>
          </div>
          <div class="ml-2 font-bold text-2xl">QuickChat</div>
        </div>
        <div
          class="flex flex-col items-center bg-indigo-100 border border-gray-200 mt-4 w-full py-6 px-4 rounded-lg"
        >
          <div class="h-20 w-20 rounded-full border overflow-hidden">
            <img
              src="https://avatars3.githubusercontent.com/u/2763884?s=128"
              alt="Avatar"
              class="h-full w-full"
            />
          </div>
          <div class="text-sm font-semibold mt-2">{{$user->name}}</div>
          <div class="text-xs text-gray-500">{{$user->email}}</div>

        </div>
        <div class="flex flex-col mt-8">
          <div class="flex flex-row items-center justify-between text-xs">
            <span class="font-bold">Active Conversations</span>
          </div>
          <div x-show="rooms.length > 0" class="flex flex-col space-y-1 mt-4 -mx-2 h-200 overflow-y-auto">

                <template x-for="room in rooms" >

                    <button @click="setRoom(room.id)"
                        :class="{ 'bg-gray-100' : room.id === currentRoom }"
                    class="flex flex-row items-center hover:bg-gray-100 rounded-xl p-2"
                    >
                        <div x-text="room.user.avatar"
                            class="flex items-center justify-center h-8 w-8 bg-gray-200 rounded-full"
                        >

                        </div>
                        <div x-text="room.user.name" class="ml-2 text-sm font-semibold"></div>
                        <div x-show="room.unread == 1"
                            class="flex items-center justify-center ml-auto text-xs text-white bg-red-500 h-4 w-10 rounded leading-none"
                        >
                            New
                        </div>
                    </button>

                </template>

          </div>
          <div class="flex flex-row items-center justify-between text-xs mt-10">
            <span class="font-bold">Contacts</span>
          </div>
          <div class="flex flex-col space-y-1 mt-4 -mx-2 h-200 overflow-y-auto">

            <template x-for="user in users" >

                <button @click="initRoom(user.id, user.name)"
                class="flex flex-row items-center hover:bg-gray-100 rounded-xl p-2"
                >
                    <div x-text="user.avatar"
                        class="flex items-center justify-center h-8 w-8 bg-gray-200 rounded-full"
                    >
                    </div>
                    <div x-text="user.name" class="ml-2 text-sm font-semibold"></div>

                </button>

            </template>

      </div>
        </div>
      </div>
      <div class="flex flex-col flex-auto h-full p-6">
        <div x-show="currentRoom > -1"
          class="flex flex-col flex-auto flex-shrink-0 rounded-2xl bg-gray-100 h-full p-4"
        >
          <div class="flex flex-col h-full overflow-x-auto mb-4">
            <div class="flex flex-col h-full flex-col-reverse overflow-auto">


                <template x-for="message in messages" >

                    <div class="grid grid-cols-12 gap-y-2">

                        <x-chat.message />

                    </div>

                </template>
            </div>

          </div>
          <div
            class="flex flex-row items-center h-16 rounded-xl bg-white w-full px-4"
          >
            <div>
              <button
                class="flex items-center justify-center text-gray-400 hover:text-gray-600"
              >
                <svg
                  class="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"
                  ></path>
                </svg>
              </button>
            </div>
            <div class="flex-grow ml-4">
              <div class="relative w-full">
                <input
                 @keyup.enter="send()"
                  type="text"
                  class="flex w-full border rounded-xl focus:outline-none focus:border-indigo-300 pl-4 h-10"
                    id="input"
                  />
                <button
                  class="absolute flex items-center justify-center h-full w-12 right-0 top-0 text-gray-400 hover:text-gray-600"
                >
                  <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    ></path>
                  </svg>
                </button>
              </div>
            </div>
            <div class="ml-4">
              <button
                @click='send()'
                class="flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded-xl text-white px-4 py-1 flex-shrink-0"
              >
                <span>Send</span>
                <span class="ml-2">
                  <svg
                    class="w-4 h-4 transform rotate-45 -mt-px"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
                    ></path>
                  </svg>
                </span>
              </button>
            </div>
          </div>
        </div>
        <div x-show="currentRoom < 1"
            class="flex flex-col flex-auto flex-shrink-0 rounded-2xl bg-gray-100 h-full p-4"
        >
            <div class="flex flex-auto justify-center items-center">
                <h2>Seja bem-vindo!</h2>
            </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('js')

<script defer>

    document.addEventListener('alpine:init', () => {

        Alpine.data('chat', () => ({

            users: @json($users),
            rooms: @js($rooms),
            currentRoom: -1,
            currentUserId: '{{auth()->user()->id}}',
            messages: [],

            async send(){

                let content = document.querySelector('#input').value

                if(content.length < 1) return;

                let body = {
                    room_id: this.currentRoom,
                    content: content,
                }

                if(this.currentRoom == 0){
                    let user_id = this.rooms[0].user.id;
                    body.user_id = user_id;
                }

                try{
                    let response =  await axios.post('{{route("messages.store")}}', body)
                    this.messages.unshift(response.data);

                    if(this.currentRoom == 0){
                        let message = response.data
                        this.rooms[0].id = message.room_id;
                        this.currentRoom = message.room_id;

                        let index = this.users.findIndex((user) => user.id == this.rooms[0].user.id);

                        if(index >= 0){
                            this.users.splice(index, 1);
                        }
                    }

                }catch(e){
                    console.log(response);
                }


                document.querySelector('#input').value = '';

            },
            setRoom(id){

                this.currentRoom = id;

                if(id != 0){
                    let index = this.rooms.findIndex((room) => room.id == 0);
                    if(index >= 0) this.rooms.splice(index, 1);

                    index = this.rooms.findIndex((room) => room.id == this.currentRoom);
                    if(index >= 0) this.rooms[index].unread = 0;
                }

                console.log(this.currentRoom);

            },
            initRoom(id, name){
                let room = {
                    id: 0,
                    active: 1,
                    user: {
                        id: id,
                        name: name,
                        avatar: name.substr(0,1)
                    }
                }

                let index = this.rooms.findIndex((room) => room.id == 0);
                if(index >= 0){
                    this.rooms[0] = room;
                }else{
                    this.rooms.unshift(room);
                }


                this.setRoom(0);

            },
            init(){
                this.$watch('currentRoom', async () => {

                    this.messages = [];

                    if(this.currentRoom < 1) return;

                    try{

                        let response = await axios.get('/messages/'+this.currentRoom)

                        this.messages = response.data;

                    }catch(e){
                        console.log(e);
                    }

                })

                setTimeout(() => {
                    console.log('rodou')
                    window.Echo.private(`user.${this.currentUserId}`)
                                .listen('NewMessage', (e) => {

                                    if(e.message.room_id == this.currentRoom){
                                        return this.messages.unshift(e.message);
                                    }

                                    let index = this.rooms.findIndex((rom) => rom.id == e.message.room_id);

                                    if(index >= 0){
                                        this.rooms[index].unread = 1;
                                        console.log(this.rooms[index]);
                                        return
                                    }

                                    e.room.unread = 1;
                                    this.rooms.unshift(e.room);

                                    index = this.users.findIndex((user) => user.id == e.room.user.id);

                                    if(index >= 0) this.users.splice(index, 1);

                                });
                }, 1000);
            }

        }))

    })

</script>

@endsection
