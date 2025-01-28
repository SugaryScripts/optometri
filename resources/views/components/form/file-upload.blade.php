@pushOnce('styles')
<link href="{{ asset('vendor/filepond-4.28.2/dist/filepond.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendor/filepond-plugin-image-preview-4.5.0/filepond-plugin-image-preview.min.css') }}" rel="stylesheet" />
<style>
    .filepond--drop-label:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }
</style>
@endPushOnce
<!-- Life is available only in the present moment. - Thich Nhat Hanh -->

@if($w_label)
    <label for="{{ $name }}" class="form-label">{{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
@endif
<div
    wire:ignore
    x-data="{
      model: @entangle($attributes['wire:model']),
      isMultiple: {{ $multiple ? 'true' : 'false' }},
      current: undefined,
      currentList: [],

      async URLtoFile(path) {
          let url = `${window.appUrlStorage}/${path}`;
          let name = url.split('/').pop();
          const response = await fetch(url);
          const data = await response.blob();
          const metadata = {
              name: name,
              size: data.size,
              type: data.type
          };
          let file = new File([data], name, metadata);
          return {
              source: file,
              options: {
                  type: 'local',
                  metadata: {
                      name: name,
                      size: file.size,
                      type: file.type
                  }
              }
          }
      }
  }"
    x-cloak
    x-init="async () => {
      let picture = model
      let files = []
      let exists = []
      if (model) {
          if (isMultiple) {
              currentList = model.map((picture) => `${window.appUrlStorage}/${picture}`);
              await Promise.all(model.map(async (picture) => exists.push(await URLtoFile(picture))))
          } else {
              if (picture) {
                  exists.push(await URLtoFile(picture))
              }
          }
      }
      files = exists
      let modelName = '{{ $attributes['wire:model'] }}'

      const notify = () => {
          new Notification()
              .title('File uploaded')
              .body(`You can save changes!`)
              .success()
              .seconds(1.5)
              .send()
      }

      const pond = FilePond.create($refs.{{ $attributes->get('ref') ?? 'input' }});
      pond.setOptions({
          allowMultiple: {{ $multiple ? 'true' : 'false' }},
          server: {
              process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                  @this.upload(modelName, file, load, error, progress)
              },
              revert: (filename, load) => {
                  @this.removeUpload(modelName, filename, load)
              },
              remove: (filename, load) => {
                  @this.removeFile(modelName, filename.name)
                  load();
              },
          },
          allowImagePreview: {{ $preview ? 'true' : 'false' }},
          imagePreviewMaxHeight: {{ $previewMax ? $previewMax : '256' }},
          allowFileTypeValidation: {{ $validate ? 'true' : 'false' }},
          acceptedFileTypes: {{ $accept ? $accept : 'null' }},
          allowFileSizeValidation: {{ $validate ? 'true' : 'false' }},
          maxFileSize: {!! $size ? "'" . $size . "'" : 'null' !!},
          maxFiles: {{ $number ? $number : 'null' }},
          required: {{ $required ? 'true' : 'false' }},
          disabled: {{ $disabled ? 'true' : 'false' }},
          onprocessfile: () => notify()
      });
      pond.addFiles(files)

      pond.on('addfile', (error, file) => {
          if (error) {
              console.log('Oh no');
              return;
          }
      });
  }"
>
    <input type="file" x-ref="{{ $attributes->get('ref') ?? 'input' }}"/>
</div>
<span class="text-danger font-size-12">@error( $attributes->whereStartsWith('wire:model')->first() ) {{ $message }}@enderror</span>

@pushonce('scripts')
<script src="{{ asset('vendor/filepond-plugin-file-validate-size-2.2.0/filepond-plugin-file-validate-size.min.js') }}"></script>
<script src="{{ asset('vendor/filepond-plugin-file-validate-type-1.2.8/filepond-plugin-file-validate-type.min.js') }}"></script>
<script src="{{ asset('vendor/filepond-plugin-image-preview-4.5.0/filepond-plugin-image-preview.min.js') }}"></script>
<script src="{{ asset('vendor/filepond-4.28.2/dist/filepond.min.js') }}"></script>
<script>
    FilePond.registerPlugin(FilePondPluginFileValidateType);
    FilePond.registerPlugin(FilePondPluginFileValidateSize);
    FilePond.registerPlugin(FilePondPluginImagePreview);
</script>
@endpushonce
