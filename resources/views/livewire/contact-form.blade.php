<form
  class="bg-yellow-300 text-gray-800 p-6 flex flex-col gap-4 rounded-2xl border border-gray-300 shadow md:rounded-[20px] xl:py-11 xl:pl-[90px] xl:pr-[60px] 2xl:rounded-[28px] 2xl:-mx-[82px]"
  id="contact"
  wire:submit="submit"
>
  <h2 class="title-2 mb-2! md:mb-4! 2xl:mb-7!">{{ App\Support\SiteContent::text('form.title') }}</h2>

  @if ($sent)
    <x-form-success />
  @endif

  <div class="flex flex-col gap-4 2xl:max-w-[1290px]">
    <div class="flex flex-col gap-4 md:grid md:grid-cols-2 xl:grid-cols-3">
      <x-field id="contact-name" model="name" :label="App\Support\SiteContent::text('form.name')" autocomplete="name" class="md:col-span-2 xl:col-span-1" />
      <x-phone-field id="contact-phone" class="xl:mt-auto" />
      <x-field id="contact-email" model="email" :label="App\Support\SiteContent::text('form.email')" autocomplete="email" />
      <x-field id="contact-message" model="message" type="textarea" :label="App\Support\SiteContent::text('form.message')" class="md:col-span-2 xl:col-span-3" />
    </div>

    <x-submit-button class="md:max-w-[368px] md:mx-auto" />
  </div>
</form>
