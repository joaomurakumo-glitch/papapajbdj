<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    private const RULES = [
        'name' => ['required', 'string', 'max:150'],
        'category' => ['required', 'string', 'max:100'],
        'price' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:99999999.99'],
        'stock' => ['required', 'integer', 'min:0', 'max:4294967295'],
    ];

    private const MESSAGES = [
        'name.required' => 'Informe o nome do produto.',
        'name.max' => 'O nome pode ter no máximo 150 caracteres.',
        'category.required' => 'Informe a categoria do produto.',
        'category.max' => 'A categoria pode ter no máximo 100 caracteres.',
        'price.required' => 'Informe o preço de venda.',
        'price.numeric' => 'O preço deve ser um valor numérico.',
        'price.decimal' => 'O preço deve ter no máximo duas casas decimais.',
        'price.min' => 'O preço não pode ser negativo.',
        'price.max' => 'O preço informado é muito alto.',
        'stock.required' => 'Informe a quantidade em estoque.',
        'stock.integer' => 'A quantidade deve ser um número inteiro.',
        'stock.min' => 'A quantidade não pode ser negativa.',
        'stock.max' => 'A quantidade informada é muito alta.',
    ];

    public function index(): View
    {
        $products = Product::query()->orderBy('name')->get();

        return view('products.index', [
            'products' => $products,
            'productCount' => $products->count(),
            'lowStockCount' => $products->where('stock', '<=', 5)->count(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Product::create($request->validate(self::RULES, self::MESSAGES));

        return redirect()
            ->route('products.index')
            ->with('success', 'Produto cadastrado com sucesso.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $product->update($request->validate(self::RULES, self::MESSAGES));

        return redirect()
            ->route('products.index')
            ->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produto excluído com sucesso.');
    }
}
