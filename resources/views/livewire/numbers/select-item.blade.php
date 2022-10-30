<div>
    <div wire:click="toggleModal" class="relative {{ $number->isReserved() ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer' }}">
        <p class="absolute w-full h-full text-2xl flex justify-center items-center">
            {{ $number->value }}
        </p>
        @if($number->isReserved())
            <div class="absolute w-full h-full flex justify-center items-center text-red-500 text-6xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-full h-full" viewBox="0 0 24 24" width="24">
                    <path d="M0 0h24v24H0V0z" fill="none"/>
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                </svg>
            </div>
        @endif
        <img src="{{ asset('images/cloud.png') }}" alt="Chá de fraldas">
    </div>


    @if($showModal)
        <div wire:click.self="toggleModal" class="flex justify-center items-center fixed z-50 top-0 left-0 w-full h-full bg-black/80 ease-in duration-300">
            <div class="bg-blue-200 text-center text-black w-11/12 md:w-10/12 lg:w-6/12 xl:w-5/12 rounded shadow p-4">
                @if($isSuccess)
                    <div class="flex flex-col items-center justify-center">
                        <div class="text-success-500">
                            <svg class="fill-current h-32 w-32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24">
                                <path d="M0 0h24v24H0V0z" fill="none"/>
                                <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                            </svg>
                        </div>
                        <p class="text-xl md:text-2xl uppercase">Reserva realizada com sucesso, boa sorte!</p>
                        <p class="my-8 md:text-3xl uppercase">Seu número: <strong>{{ $number->value }}</strong></p>


                        <div class="flex space-x-4 w-full">
                            <button wire:click.prevent="toggleModal" class="block font-bolder mt-4 text-center uppercase bg-danger-500 text-white w-full rounded py-3 hover:bg-danger-600 transition">
                                Fechar
                            </button>

                            @if($contactPhone = config('numbers.contact_phone'))
                                <a target="_blank" href="//wa.me/{{ $contactPhone }}?text=Olá, selecionei o número {{ $number->value }} para o chá de fraldas!" class="block font-bolder mt-4 text-center uppercase bg-yellow-400 w-full rounded py-3 hover:bg-yellow-500 transition">Enviar mensagem para confirmação</a>
                            @endif
                        </div>
                    </div>
                @else
                    <p class="uppercase text-xl border-b border-gray-700/25 pb-1">Você está reservando o número: <strong>{{ $number->value }}</strong></p>

                    <form wire:submit.prevent="save" class="mt-4 text-left">
                        {{ $this->form }}

                        <div class="flex space-x-4">
                            <button wire:click.prevent="toggleModal" class="block font-bolder mt-4 text-center uppercase bg-danger-500 text-white w-full rounded py-3 hover:bg-danger-600 transition" type="button">
                                Cancelar
                            </button>
                            <button class="block font-bolder mt-4 text-center uppercase bg-yellow-400 w-full rounded py-3 hover:bg-yellow-500 transition" type="submit">
                                Reservar o número!
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endif
</div>
