<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Number;

class OrderResource extends Resource
{
    protected static ?string $navigationLabel = 'Orders';

    protected static ?string $modelLabel = 'Orders';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Manajemen Pesanan';

    protected static ?string $recordTitleAttribute = 'id';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() > 0 ? 'warning' : 'primary';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Membungkus seluruh form dalam Card dengan kelas w-full
                \Filament\Forms\Components\Card::make()
                    ->extraAttributes(['class' => 'w-full'])
                    ->schema([
                        Wizard::make([
                            Step::make('Informasi Dasar')
                                ->icon('heroicon-o-information-circle')
                                ->description('Detail utama pesanan')
                                ->schema([
                                    Section::make('Informasi Pesanan')
                                        ->description('Masukkan detail utama pesanan')
                                        ->icon('heroicon-o-clipboard-document')

                                        ->columns(2)
                                        ->schema([
                                            Select::make('customer_id')
                                                ->relationship('customer', 'name')
                                                ->required()
                                                ->label('Pelanggan')
                                                ->searchable()
                                                ->preload()
                                                ->native(false)
                                                ->placeholder('Pilih pelanggan')
                                                ->createOptionForm([
                                                    TextInput::make('name')
                                                        ->required()
                                                        ->label('Nama Pelanggan'),
                                                    TextInput::make('phone')
                                                        ->tel()
                                                        ->required()
                                                        ->label('No. Telepon'),
                                                    TextInput::make('email')
                                                        ->email()
                                                        ->label('Email'),
                                                    Textarea::make('address')
                                                        ->required()
                                                        ->label('Alamat'),
                                                ])
                                                ->createOptionAction(function (Action $action) {
                                                    return $action
                                                        ->modalHeading('Tambah Pelanggan Baru')
                                                        ->modalWidth('md');
                                                })
                                                ->suffixIcon('heroicon-o-user')
                                                ->hintIcon('heroicon-o-information-circle')
                                                ->hintColor('primary')
                                                ->hint('Pilih atau tambahkan pelanggan baru'),

                                            Select::make('event_type')
                                                ->label('Tipe Acara')
                                                ->options([
                                                    'Pernikahan' => 'Pernikahan',
                                                    'Ulang Tahun' => 'Ulang Tahun',
                                                    'Gathering' => 'Gathering',
                                                    'Seminar' => 'Seminar',
                                                    'Catering Karyawan Pabrik' => 'Catering Karyawan Pabrik',
                                                    'Lainnya' => 'Lainnya',
                                                ])
                                                ->live()
                                                ->required()
                                                ->native(false)
                                                ->suffixIcon('heroicon-o-tag')
                                                ->hintIcon('heroicon-o-information-circle')
                                                ->hint('Pilih jenis acara'),

                                            TextInput::make('custom_event_type')
                                                ->label('Tipe Acara Kustom')
                                                ->hidden(fn (Get $get) => $get('event_type') !== 'Lainnya')
                                                ->required(fn (Get $get) => $get('event_type') === 'Lainnya')
                                                ->placeholder('Masukkan tipe acara custom')
                                                ->suffixIcon('heroicon-o-pencil'),

                                            Forms\Components\Group::make()
                                                ->columns(1)
                                                ->schema([
                                                    DatePicker::make('scheduled_date')
                                                        ->required()
                                                        ->label('Tanggal Pelaksanaan')
                                                        ->native(false)
                                                        ->displayFormat('d M Y')
                                                        ->minDate(function () {
                                                            // Jika route adalah create, maka tetapkan minDate, jika edit, biarkan tanpa batasan (null)
                                                            return request()->route()->getName() === 'filament.admin.resources.orders.create'
                                                                ? now()->addDays(1)
                                                                : null;
                                                        })
                                                        ->weekStartsOnMonday()
                                                        ->suffixIcon('heroicon-o-calendar')
                                                        ->closeOnDateSelection(),

                                                ]),
                                        ]),

                                    Section::make('Lokasi dan Detail Kontak')
                                        ->description('Masukkan informasi detail lokasi acara')
                                        ->icon('heroicon-o-map-pin')

                                        ->schema([
                                            Textarea::make('tujuan')
                                                ->required()
                                                ->label('Alamat Tujuan')
                                                ->placeholder('Masukkan detail alamat lengkap')
                                                ->rows(3)
                                                ->columnSpanFull(),
                                        ]),

                                    Select::make('status')
                                        ->label('Status Pesanan')
                                        ->options([
                                            'pending' => 'Pending (Pesanan Diproses)',
                                            'processing' => 'Processing (Pesanan Sedang Diproses)',
                                            'completed' => 'Completed (Pesanan Selesai)',
                                            'cancelled' => 'Cancelled (Pesanan Dibatalkan)',
                                        ])
                                        ->default('pending')
                                        ->required()
                                        ->live()
                                        ->native(false)
                                        ->hiddenOn('create')
                                        ->columnSpanFull()
                                        ->suffixIcon(fn (Get $get) => match ($get('status')) {
                                            'pending' => 'heroicon-o-clock',
                                            'processing' => 'heroicon-o-arrow-path',
                                            'completed' => 'heroicon-o-check-circle',
                                            'cancelled' => 'heroicon-o-x-circle',
                                            default => 'heroicon-o-question-mark-circle',
                                        })
                                        ->suffixIconColor(fn (Get $get) => match ($get('status')) {
                                            'pending' => 'warning',
                                            'processing' => 'info',
                                            'completed' => 'success',
                                            'cancelled' => 'danger',
                                            default => 'gray',
                                        }),
                                ]),

                            Step::make('Detail Menu Pesanan')
                                ->icon('heroicon-o-clipboard-document-list')
                                ->description('Pilih menu untuk pesanan')
                                ->schema([
                                    Tabs::make('PilihJenisPesanan')
                                        ->tabs([
                                            Tabs\Tab::make('Menu Satuan')
                                                ->icon('heroicon-o-squares-2x2')
                                                ->schema([
                                                    Repeater::make('items')
                                                        ->relationship('items')
                                                        ->schema([
                                                            Grid::make(4)
                                                                ->schema([
                                                                    // Ubah columnSpan menu_id agar space untuk harga satuan tersedia
                                                                    Select::make('menu_id')
                                                                        ->relationship('menu', 'name')
                                                                        ->required()
                                                                        ->label('Nama Menu')
                                                                        ->live()
                                                                        ->afterStateUpdated(function ($state, $set, $get) {
                                                                            // Dapatkan harga dari menu dan update field harga satuan
                                                                            $menu = \App\Models\Menu::find($state);
                                                                            $price = $menu?->price ?? 0;
                                                                            $set('price', $price);
                                                                            self::updateSubtotal($state, $set, $get, 'menu');
                                                                        })
                                                                        ->searchable()
                                                                        ->preload()
                                                                        ->placeholder('Pilih menu')
                                                                        ->columnSpan(2),

                                                                    // Field harga satuan (unit price)
                                                                    Placeholder::make('price')
                                                                        ->label('Harga Satuan')
                                                                        ->content(function (Get $get) {
                                                                            $menuId = $get('menu_id');
                                                                            if (! $menuId) {
                                                                                return 'Rp 0';
                                                                            }
                                                                            $price = Menu::find($menuId)?->price ?? 0;

                                                                            return 'Rp '.Number::format($price, locale: 'id');
                                                                        })
                                                                        ->columnSpan(1),

                                                                    // Field quantity
                                                                    TextInput::make('quantity')
                                                                        ->numeric()
                                                                        ->required()
                                                                        ->default(10)
                                                                        ->minValue(10)
                                                                        ->label('Jumlah')
                                                                        ->live()
                                                                        ->afterStateUpdated(function ($state, $set, $get) {
                                                                            self::updateSubtotal($get('menu_id'), $set, $get, 'menu');
                                                                        })
                                                                        ->suffixIcon('heroicon-o-plus')
                                                                        ->columnSpan(1),

                                                                    // Field subtotal pada baris baru
                                                                    TextInput::make('subtotal')
                                                                        ->numeric()
                                                                        ->prefix('Rp')
                                                                        ->disabled()
                                                                        ->dehydrated()
                                                                        ->label('Subtotal')
                                                                        ->formatStateUsing(fn ($state) => \Illuminate\Support\Number::format($state ?? 0, locale: 'id'))
                                                                        ->columnSpan(4),
                                                                ]),
                                                            TextInput::make('special_request')
                                                                ->label('Permintaan Khusus')
                                                                ->placeholder('Mis: Level pedas, tanpa MSG, dll')
                                                                ->columnSpanFull(),
                                                        ])
                                                        ->label('Menu Satuan')
                                                        ->itemLabel(fn (array $state): ?string => \App\Models\Menu::find($state['menu_id'])?->name ?? 'Pilih Menu')
                                                        ->defaultItems(1)
                                                        ->addActionLabel('Tambah Menu'),
                                                ]),

                                            Tabs\Tab::make('Paket Menu')
                                                ->icon('heroicon-o-queue-list')
                                                ->schema([
                                                    Repeater::make('packages')
                                                        ->relationship('packages')
                                                        ->schema([
                                                            Grid::make(4)
                                                                ->schema([
                                                                    Select::make('package_id')
                                                                        ->relationship('package', 'name')
                                                                        ->required() // validasi required
                                                                        ->label('Nama Paket')
                                                                        ->live()
                                                                        ->afterStateUpdated(function ($state, $set, $get) {
                                                                            self::updateSubtotal($state, $set, $get, 'package');
                                                                        })
                                                                        ->searchable()
                                                                        ->preload()
                                                                        ->columnSpan(2)
                                                                        ->placeholder('Pilih paket'),

                                                                    Placeholder::make('total_price')
                                                                        ->label('Harga Satuan')
                                                                        ->content(function (Get $get) {
                                                                            $packageId = $get('package_id');
                                                                            if (! $packageId) {
                                                                                return 'Rp 0';
                                                                            }
                                                                            $price = Package::find($packageId)?->total_price ?? 0;

                                                                            return 'Rp '.Number::format($price, locale: 'id');
                                                                        })
                                                                        ->columnSpan(1),

                                                                    TextInput::make('quantity')
                                                                        ->numeric()
                                                                        ->required()
                                                                        ->default(10)
                                                                        ->minValue(10)
                                                                        ->label('Jumlah')
                                                                        ->live()
                                                                        ->afterStateUpdated(function ($state, $set, $get) {
                                                                            self::updateSubtotal($get('package_id'), $set, $get, 'package');
                                                                        })
                                                                        ->suffixIcon('heroicon-o-plus'),

                                                                    TextInput::make('subtotal')
                                                                        ->numeric()
                                                                        ->prefix('Rp')
                                                                        ->disabled()
                                                                        ->dehydrated()
                                                                        ->label('Subtotal')
                                                                        ->formatStateUsing(fn ($state) => Number::format($state ?? 0, locale: 'id'))
                                                                        ->columnSpan(4),
                                                                ]),
                                                        ])
                                                        ->label('Paket Menu')

                                                        ->itemLabel(fn (array $state): ?string => Package::find($state['package_id'])?->name ?? 'Pilih Paket')
                                                        ->defaultItems(1)
                                                        ->addActionLabel('Tambah Paket'),
                                                ]),
                                        ]),
                                ]),

                            Step::make('Rincian Biaya & Pembayaran')
                                ->icon('heroicon-o-currency-dollar')
                                ->description('Detail biaya dan metode pembayaran')
                                ->schema([
                                    Section::make('Ringkasan Pesanan')
                                        ->description('Rincian pesanan dan total biaya')
                                        ->icon('heroicon-o-calculator')
                                        ->schema([
                                            Placeholder::make('order_summary')
                                                ->content(function (Get $get) {
                                                    // Mengumpulkan data menu yang dipilih
                                                    $menuItems = collect($get('items') ?? [])
                                                        ->filter(fn ($item) => ! empty($item['menu_id']) && ! empty($item['quantity']))
                                                        ->map(function ($item) {
                                                            $menu = \App\Models\Menu::find($item['menu_id']);

                                                            return [
                                                                'name' => $menu?->name ?? 'Menu tidak ditemukan',
                                                                'price' => $menu?->price ?? 0,
                                                                'quantity' => $item['quantity'] ?? 0,
                                                                'subtotal' => $item['subtotal'] ?? 0,
                                                            ];
                                                        });

                                                    // Mengumpulkan data paket yang dipilih
                                                    $packageItems = collect($get('packages') ?? [])
                                                        ->filter(fn ($package) => ! empty($package['package_id']) && ! empty($package['quantity']))
                                                        ->map(function ($package) {
                                                            $packageModel = \App\Models\Package::find($package['package_id']);

                                                            return [
                                                                'name' => $packageModel?->name ?? 'Paket tidak ditemukan',
                                                                'price' => $packageModel?->total_price ?? 0,
                                                                'quantity' => $package['quantity'] ?? 0,
                                                                'subtotal' => $package['subtotal'] ?? 0,
                                                            ];
                                                        });

                                                    // Menghitung total item dan total quantity
                                                    $totalItems = $menuItems->count() + $packageItems->count();
                                                    $totalQuantity = $menuItems->sum('quantity') + $packageItems->sum('quantity');

                                                    return view('filament.components.order-summary', [
                                                        'menuItems' => $menuItems,
                                                        'packageItems' => $packageItems,
                                                        'totalItems' => $totalItems,
                                                        'totalQuantity' => $totalQuantity,
                                                    ]);
                                                })
                                                ->columnSpanFull(),
                                            // Field Total Harga yang sudah ada
                                            Forms\Components\Group::make()
                                                ->schema([
                                                    TextInput::make('total_price')
                                                        ->numeric()
                                                        ->prefix('Rp')
                                                        ->disabled()
                                                        ->dehydrated()
                                                        ->label('Total Harga')
                                                        ->default(0)
                                                        // Solusi 1: Jangan gunakan formatStateUsing pada field numeric
                                                        // ->formatStateUsing(fn($state) => \Illuminate\Support\Number::format($state, locale: 'id'))
                                                        ->extraAttributes([
                                                            'class' => 'font-bold text-lg text-primary-600 dark:text-primary-400',
                                                        ])
                                                        ->columnSpanFull(),
                                                ])
                                                ->columns(1),
                                        ])
                                        ->columns(2),

                                    Section::make('Ketentuan Pembayaran')
                                        ->description('Informasi metode dan jadwal pembayaran')
                                        ->icon('heroicon-o-banknotes')
                                        ->schema([
                                            Select::make('payment_method')
                                                ->label('Metode Pembayaran')
                                                ->options([
                                                    'transfer_bank' => 'Transfer Bank',
                                                    'tunai' => 'Tunai/Cash',
                                                    'qris' => 'QRIS',
                                                ])
                                                ->default('transfer_bank')
                                                ->required()
                                                ->native(false)
                                                ->suffixIcon('heroicon-o-credit-card'),

                                            Forms\Components\Group::make()
                                                ->schema([
                                                    TextInput::make('down_payment')
                                                        ->numeric()
                                                        ->prefix('Rp')
                                                        ->label('Uang Muka (DP)')
                                                        ->default(0)
                                                        ->required()
                                                        ->live(onBlur: true)
                                                        ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                                            // Pastikan nilai dikonversi ke integer terlebih dahulu
                                                            $totalPrice = (int) $get('total_price') ?? 0;
                                                            $downPayment = (int) $state ?? 0;
                                                            $set('remaining_payment', max(0, $totalPrice - $downPayment));
                                                        }),

                                                    TextInput::make('remaining_payment')
                                                        ->numeric()
                                                        ->prefix('Rp')
                                                        ->disabled()
                                                        ->dehydrated()
                                                        ->label('Sisa Pembayaran')
                                                        ->default(0)
                                                    // Hindari penggunaan formatStateUsing di sini juga
                                                    // ->formatStateUsing(fn($state) => Number::format($state, locale: 'id'))
                                                    ,
                                                ])
                                                ->columns(2),

                                            FileUpload::make('payment_proof')
                                                ->label('Bukti Pembayaran')
                                                ->directory('payment-proofs')
                                                ->preserveFilenames()
                                                ->maxSize(2048)
                                                ->rules('required', 'file', 'mimes:jpeg,png,pdf', 'max:2048')
                                                ->helperText('Unggah bukti pembayaran (JPEG, PNG, PDF, maks. 2MB)'),

                                            RichEditor::make('payment_notes')
                                                ->label('Catatan Pembayaran')
                                                ->placeholder('Tambahkan catatan mengenai pembayaran jika ada')
                                                ->columnSpanFull()
                                                ->toolbarButtons([
                                                    'bold',
                                                    'italic',
                                                    'bulletList',
                                                    'orderedList',
                                                ])
                                                ->disableToolbarButtons([
                                                    'attachFiles',
                                                    'blockquote',
                                                    'strike',
                                                ]),
                                        ]),
                                ]),

                            Step::make('Finalisasi')
                                ->icon('heroicon-o-document-check')
                                ->description('Finalisasi dan catatan tambahan')
                                ->schema([
                                    Section::make('Catatan Tambahan')
                                        ->icon('heroicon-o-pencil-square')
                                        ->schema([
                                            Textarea::make('special_instructions')
                                                ->label('Instruksi Khusus')
                                                ->placeholder('Tambahkan instruksi khusus atau permintaan untuk pesanan ini')
                                                ->rows(3)
                                                ->columnSpanFull(),
                                        ]),

                                    Section::make('Pesanan Disiapkan Oleh')
                                        ->icon('heroicon-o-user-circle')
                                        ->schema([
                                            Select::make('staff')
                                                ->label('Disiapkan Oleh')
                                                ->relationship('staff', 'name') // Relasi Many-to-Many
                                                ->multiple() // Aktifkan multiple select
                                                ->searchable()
                                                ->preload()
                                                ->placeholder('Pilih staff yang menyiapkan pesanan...')
                                                ->columnSpan(3),
                                        ])
                                        ->columns(2),
                                ]),
                        ]),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->customer->phone ?? '-'),

                TextColumn::make('event_type')
                    ->label('Tipe Acara')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->custom_event_type),

                TextColumn::make('total_price')
                    ->label('Total Harga')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->color('success')
                    ->weight('bold'),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'processing',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->icons([
                        'pending' => 'heroicon-o-clock',
                        'processing' => 'heroicon-o-arrow-path',
                        'completed' => 'heroicon-o-check-circle',
                        'cancelled' => 'heroicon-o-x-circle',
                    ])
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->multiple()
                    ->label('Status Pesanan'),

                SelectFilter::make('event_type')
                    ->options([
                        'Pernikahan' => 'Pernikahan',
                        'Ulang Tahun' => 'Ulang Tahun',
                        'Gathering' => 'Gathering',
                        'Seminar' => 'Seminar',
                        'Catering Karyawan Pabrik' => 'Catering Karyawan Pabrik',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->multiple()
                    ->label('Tipe Acara'),
            ])
            ->actions([
                // Ubah ViewAction menjadi Action custom
                Tables\Actions\Action::make('view')
                    ->label('Invoice Pesanan')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Order $record) => route('filament.admin.resources.orders.view-invoice', $record))
                    ->openUrlInNewTab(),

                // Action lainnya
                Tables\Actions\Action::make('process')
                    ->label('Proses Pesanan')
                    ->icon('heroicon-o-arrow-path')
                    ->hidden(fn ($record) => $record->status !== 'pending')
                    ->action(fn ($record) => $record->markAsProcessing()),

                Tables\Actions\Action::make('complete')
                    ->label('Tandai Selesai')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->hidden(fn ($record) => $record->status === 'completed')
                    ->action(fn ($record) => $record->completeOrder()),

                Tables\Actions\Action::make('cancel')
                    ->label('Batalkan')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->cancelOrder()),

                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil-square'),

                Tables\Actions\Action::make('viewPaymentProof')
                    ->label('Bukti Pembayaran')
                    ->icon('heroicon-o-envelope-open') // Anda bisa pilih icon lain sesuai preferensi
                    ->url(fn (Order $record) => route('filament.admin.resources.orders.view-payment-proof', $record))
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => ! empty($record->payment_proof)),  // Hanya tampil jika bukti pembayaran ada

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->icon('heroicon-o-trash'),
                    Tables\Actions\BulkAction::make('markAsCompleted')
                        ->label('Tandai Selesai')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn ($records) => $records->each->update(['status' => 'completed'])),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view-invoice' => Pages\ViewInvoice::route('/{record}/invoice'),
            'view-payment-proof' => Pages\PaymentProof::route('/{record}/payment-proof'),
        ];
    }

    /**
     * Update subtotal untuk menu atau paket berdasarkan ID dan quantity yang diinput.
     *
     * @param  mixed  $id
     * @param  Set  $set
     * @param  Get  $get
     * @param  string  $type  ('menu' atau 'package')
     * @return void
     */
    private static function updateSubtotal($id, $set, $get, $type)
    {
        // Cek apakah menu/paket belum diisi atau sudah dihapus
        if (! $id) {
            Notification::make()
                ->warning()
                ->title('Peringatan')
                ->body('Menu/Paket belum diisi atau sudah dihapus!')
                ->send();

            $set('subtotal', 0);

            return;
        }

        $price = $type === 'menu'
            ? Menu::find($id)?->price ?? 0
            : Package::find($id)?->total_price ?? 0;

        $quantity = $get('quantity') ?? 0;
        $subtotal = $price * $quantity;
        $set('subtotal', $subtotal);

        $total = collect($get('../../items'))->sum(fn ($item) => $item['subtotal'] ?? 0) +
            collect($get('../../packages'))->sum(fn ($item) => $item['subtotal'] ?? 0);

        $set('../../total_price', $total);

        // Auto update status jika total > 0 dan masih pending
        if ($total > 0 && $get('../../status') === 'pending') {
            $set('../../status', 'processing');
        }
    }
}
\Log::info(request()->all());
