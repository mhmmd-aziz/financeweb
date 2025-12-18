<x-mail::message>
<div style="text-align: center; margin-bottom: 20px;">
<img src="https://cdn-icons-png.flaticon.com/512/744/744922.png" alt="Success" style="width: 80px; height: 80px;">
</div>
<h1 style="text-align: center; color: #333; margin: 0;">Target Tercapai! 🎉</h1>
<p style="text-align: center; color: #666; font-size: 16px;">Halo <strong>{{ $goal->user->name }}</strong>, selamat! Kamu berhasil menaklukkan target finansialmu.</p>

<x-mail::panel>
<div style="text-align: center; width: 100%;">
<p style="margin: 0; font-size: 12px; text-transform: uppercase; letter-spacing: 2px; color: #999;">TARGET: {{ strtoupper($goal->title) }}</p>
<h2 style="margin: 15px 0; font-size: 36px; font-weight: 800; color: #10b981; line-height: 1;">
Rp {{ number_format($goal->current_amount, 0, ',', '.') }}
</h2>
<div style="background-color: #d1fae5; color: #065f46; padding: 6px 16px; border-radius: 50px; display: inline-block; font-size: 12px; font-weight: bold; margin-bottom: 20px;">
100% TERCAPAI
</div>
<div style="border-top: 2px dashed #e5e7eb; margin: 0; padding-top: 20px;"></div>
<table style="width: 100%; font-size: 14px;">
<tr>
<td style="text-align: left; color: #6b7280; padding-bottom: 8px;">Target Awal</td>
<td style="text-align: right; font-weight: bold; color: #111827; padding-bottom: 8px;">Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</td>
</tr>
<tr>
<td style="text-align: left; color: #6b7280;">Tanggal Tercapai</td>
<td style="text-align: right; font-weight: bold; color: #111827;">{{ now()->format('d M Y') }}</td>
</tr>
</table>
</div>
</x-mail::panel>

<p style="text-align: center; font-style: italic; color: #666; margin-top: 20px;">"Konsistensi adalah kunci. Satu target selesai, siap untuk target berikutnya?"</p>

<x-mail::button :url="url('/app')">
🏆 Buat Target Baru
</x-mail::button>

<div style="text-align: center; font-size: 12px; color: #aaa; margin-top: 30px;">
Salam Sukses,<br>Tim {{ config('app.name') }}
</div>
</x-mail::message>