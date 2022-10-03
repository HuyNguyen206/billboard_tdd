<div class="bg-white mb-2 p-2">
    <form>
        <div class="flex justify-between @if($completed) text-gray-400 @endif">
            <div class="w-full">
                <form>
                    <input wire:keydown.enter.prevent="updateTask" type="text" class="w-full border-none " wire:model.500ms="body" value="{{$body}}">
                    @error('body')
                    <p id="standard_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </p>
                    @enderror
                </form>
            </div>
            <input type="checkbox" @checked($completed) wire:change="updateTask"  wire:model="completed">
        </div>
    </form>
</div>
