@props(['tab'])
<div class="flex items-center gap-1 border-b border-outline-variant">
@foreach([['gudang','warehouse','Daftar Gudang'],['rak','shelves','Daftar Rak'],['row','view_column','Daftar Row'],['lokasi','account_tree','Struktur Lokasi']] as [$key,$icon,$label])
<a href="{{ route('master-gudang.index',['tab'=>$key]) }}" class="inline-flex items-center gap-2 border-b-2 px-4 py-3 font-label-bold {{ $tab===$key ? 'border-primary text-primary' : 'border-transparent text-on-surface-variant hover:border-outline hover:text-primary' }}"><span class="material-symbols-outlined text-[21px]">{{ $icon }}</span>{{ $label }}</a>
@endforeach
</div>
