<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estoque | {{ config('app.name', 'Mercadinho do Seu João') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        :root {
            --market-green: #355b43;
            --market-green-dark: #284735;
            --market-background: #f3f6f2;
        }

        body {
            min-height: 100vh;
            background: var(--market-background);
            color: #27332a;
        }

        .market-navbar,
        .btn-success {
            background-color: var(--market-green);
            border-color: var(--market-green);
        }

        .market-navbar .navbar-brand,
        .market-navbar .navbar-text {
            color: #fff;
        }

        .btn-success:hover,
        .btn-success:focus {
            background-color: var(--market-green-dark);
            border-color: var(--market-green-dark);
        }

        .card {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 0.35rem 1.25rem rgba(35, 55, 40, 0.07);
        }

        .form-control {
            min-height: 44px;
        }

        .badge {
            padding: 0.45em 0.75em;
            font-size: 0.85rem;
        }

        .badge-success {
            background-color: #d8eee0;
            color: #21613a;
        }

        .badge-danger {
            background-color: #f8d7da;
            color: #8b1e2b;
        }

        .table th {
            border-top: 0;
            color: #6c7770;
            font-size: 0.78rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .product-name {
            color: #27332a;
            font-weight: 600;
        }

        .section-eyebrow {
            color: var(--market-green);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar market-navbar">
        <div class="container">
            <a class="navbar-brand font-weight-bold" href="{{ route('products.index') }}">
                Mercadinho do Seu João
            </a>
            <span class="navbar-text d-none d-sm-inline">Controle de estoque</span>
        </div>
    </nav>

    <main class="container py-4 py-md-5">
        <header class="mb-4">
            <p class="section-eyebrow mb-1">Balcão e estoque</p>
            <h1 class="h3 mb-1">Produtos do mercadinho</h1>
            <p class="text-muted mb-0">Cadastre mercadorias e confira o que precisa ser reposto.</p>
        </header>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <section class="col-lg-4 mb-4" aria-labelledby="new-product-heading">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <p class="section-eyebrow mb-1">Novo cadastro</p>
                        <h2 id="new-product-heading" class="h5 mb-4">Adicionar produto</h2>

                        <form method="POST" action="{{ route('products.store') }}">
                            @csrf
                            <input type="hidden" name="_form" value="create">

                            <div class="form-group">
                                <label for="name">Nome do produto</label>
                                <input id="name" name="name" type="text" maxlength="150"
                                       class="form-control rounded-pill @if (old('_form') === 'create' && $errors->has('name')) is-invalid @endif"
                                       placeholder="Ex.: Arroz Tio João 5kg"
                                       value="{{ old('_form') === 'create' ? old('name') : '' }}" required>
                                @if (old('_form') === 'create')
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="category">Categoria</label>
                                <input id="category" name="category" type="text" maxlength="100"
                                       class="form-control rounded-pill @if (old('_form') === 'create' && $errors->has('category')) is-invalid @endif"
                                       list="product-categories" placeholder="Ex.: Mercearia"
                                       value="{{ old('_form') === 'create' ? old('category') : '' }}" required>
                                <datalist id="product-categories">
                                    <option value="Mercearia">
                                    <option value="Limpeza">
                                    <option value="Bebidas">
                                    <option value="Hortifruti">
                                    <option value="Frios e laticínios">
                                </datalist>
                                @if (old('_form') === 'create')
                                    @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @endif
                            </div>

                            <div class="form-row">
                                <div class="form-group col-sm-7">
                                    <label for="price">Preço de venda (R$)</label>
                                    <input id="price" name="price" type="number" min="0" step="0.01"
                                           class="form-control rounded-pill @if (old('_form') === 'create' && $errors->has('price')) is-invalid @endif"
                                           placeholder="0,00"
                                           value="{{ old('_form') === 'create' ? old('price') : '' }}" required>
                                    @if (old('_form') === 'create')
                                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @endif
                                </div>
                                <div class="form-group col-sm-5">
                                    <label for="stock">Estoque</label>
                                    <input id="stock" name="stock" type="number" min="0" step="1"
                                           class="form-control rounded-pill @if (old('_form') === 'create' && $errors->has('stock')) is-invalid @endif"
                                           placeholder="0"
                                           value="{{ old('_form') === 'create' ? old('stock') : '' }}" required>
                                    @if (old('_form') === 'create')
                                        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @endif
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success btn-block rounded-pill mt-2">
                                Cadastrar produto
                            </button>
                        </form>
                    </div>
                </div>
            </section>

            <section class="col-lg-8 mb-4" aria-labelledby="product-list-heading">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-3">
                            <div class="mb-3 mb-sm-0">
                                <p class="section-eyebrow mb-1">Visão geral</p>
                                <h2 id="product-list-heading" class="h5 mb-0">Estoque cadastrado</h2>
                            </div>
                            <div class="d-flex">
                                <span class="badge badge-light mr-2">{{ $productCount }} produto(s)</span>
                                <span class="badge badge-danger">{{ $lowStockCount }} acabando</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="sr-only" for="product-search">Buscar produto</label>
                            <input id="product-search" type="search" class="form-control rounded-pill"
                                   placeholder="Buscar por produto ou categoria...">
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Produto</th>
                                        <th scope="col">Categoria</th>
                                        <th scope="col">Preço</th>
                                        <th scope="col">Estoque</th>
                                        <th scope="col" class="text-right">Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="product-list">
                                    @forelse ($products as $product)
                                        <tr class="product-row">
                                            <td class="product-name">{{ $product->name }}</td>
                                            <td>{{ $product->category }}</td>
                                            <td class="text-nowrap">R$ {{ number_format((float) $product->price, 2, ',', '.') }}</td>
                                            <td>
                                                @if ($product->stock <= 5)
                                                    <span class="badge badge-danger">{{ $product->stock }} un.</span>
                                                @else
                                                    <span class="badge badge-success">{{ $product->stock }} un.</span>
                                                @endif
                                            </td>
                                            <td class="text-right text-nowrap">
                                                <button type="button" class="btn btn-sm btn-outline-success"
                                                        data-toggle="modal" data-target="#editProduct{{ $product->id }}">
                                                    Editar
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-toggle="modal" data-target="#deleteProduct{{ $product->id }}">
                                                    Excluir
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr id="empty-products">
                                            <td colspan="5" class="py-5 text-center text-muted">
                                                Nenhum produto cadastrado. Use o formulário para começar.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <p id="no-search-results" class="d-none text-center text-muted mb-0 py-4">
                                Nenhum produto encontrado para essa busca.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    @foreach ($products as $product)
        @php($editingProduct = old('_form') === 'edit:'.$product->id)

        <div class="modal fade" id="editProduct{{ $product->id }}" tabindex="-1" role="dialog"
             aria-labelledby="editProductLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0 rounded-lg">
                    <div class="modal-header">
                        <h2 class="modal-title h5" id="editProductLabel{{ $product->id }}">Editar produto</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('products.update', $product) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="_form" value="edit:{{ $product->id }}">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="edit-name-{{ $product->id }}">Nome do produto</label>
                                <input id="edit-name-{{ $product->id }}" name="name" type="text" maxlength="150"
                                       class="form-control rounded-pill @if ($editingProduct && $errors->has('name')) is-invalid @endif"
                                       value="{{ $editingProduct ? old('name') : $product->name }}" required>
                                @if ($editingProduct)
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="edit-category-{{ $product->id }}">Categoria</label>
                                <input id="edit-category-{{ $product->id }}" name="category" type="text" maxlength="100"
                                       class="form-control rounded-pill @if ($editingProduct && $errors->has('category')) is-invalid @endif"
                                       value="{{ $editingProduct ? old('category') : $product->category }}" required>
                                @if ($editingProduct)
                                    @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @endif
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-7 mb-sm-0">
                                    <label for="edit-price-{{ $product->id }}">Preço de venda (R$)</label>
                                    <input id="edit-price-{{ $product->id }}" name="price" type="number" min="0" step="0.01"
                                           class="form-control rounded-pill @if ($editingProduct && $errors->has('price')) is-invalid @endif"
                                           value="{{ $editingProduct ? old('price') : $product->price }}" required>
                                    @if ($editingProduct)
                                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @endif
                                </div>
                                <div class="form-group col-sm-5 mb-0">
                                    <label for="edit-stock-{{ $product->id }}">Estoque</label>
                                    <input id="edit-stock-{{ $product->id }}" name="stock" type="number" min="0" step="1"
                                           class="form-control rounded-pill @if ($editingProduct && $errors->has('stock')) is-invalid @endif"
                                           value="{{ $editingProduct ? old('stock') : $product->stock }}" required>
                                    @if ($editingProduct)
                                        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light rounded-pill" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success rounded-pill">Salvar alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteProduct{{ $product->id }}" tabindex="-1" role="dialog"
             aria-labelledby="deleteProductLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0 rounded-lg">
                    <div class="modal-header">
                        <h2 class="modal-title h5" id="deleteProductLabel{{ $product->id }}">Excluir produto</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Tem certeza de que deseja excluir <strong>{{ $product->name }}</strong>? Esta ação não pode ser desfeita.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light rounded-pill" data-dismiss="modal">Cancelar</button>
                        <form method="POST" action="{{ route('products.destroy', $product) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-pill">Excluir produto</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if ($editingProduct)
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    $('#editProduct{{ $product->id }}').modal('show');
                });
            </script>
        @endif
    @endforeach

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('product-search').addEventListener('input', function (event) {
            var searchTerm = event.target.value.trim().toLocaleLowerCase('pt-BR');
            var rows = document.querySelectorAll('.product-row');
            var visibleRows = 0;

            rows.forEach(function (row) {
                var matches = row.textContent.toLocaleLowerCase('pt-BR').includes(searchTerm);
                row.classList.toggle('d-none', !matches);
                visibleRows += matches ? 1 : 0;
            });

            document.getElementById('no-search-results').classList.toggle('d-none', visibleRows > 0 || rows.length === 0);
        });
    </script>
</body>
</html>
