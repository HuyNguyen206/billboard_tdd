<div
    x-data="{
                theme:'',
                changeTheme(theme) {
                   this.theme = localStorage.setItem('theme', theme)

                   document.body.className = document.body.className.replace(/theme-\w+/, theme)
                }
                }"
>
    <button @click="changeTheme('theme-light')" class="rounded-full w-6 h-6 bg-gray-50 border-2"
            style="border-color: #47cdff"></button>
    <button @click="changeTheme('theme-dark')" class="rounded-full w-6 h-6 bg-gray-900 border-2"
            style="border-color: #47cdff "></button>
</div>
