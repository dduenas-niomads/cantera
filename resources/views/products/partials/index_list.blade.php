
                                @foreach ($list as $key => $value)
                                    @include('layouts.utils.products')
                                    <tr class="{{ $value->tr_class_name }}" id="row_{{ $value->id }}">
                                        <td>{{ $value->code }}</td>
                                        <td>{{ $value->category }}</td>
                                        <td>{{ $value->brand }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->description }}</td>
                                        <td>{{ ($value->price_compra) ? number_format($value->price_compra) : 0 }} <br> {{ $value->currency }}</td>
                                        <td>{{ ($value->price_sale) ? number_format($value->price_sale) : 0 }} <br> {{ $value->currency }}</td>
                                        <td>{{ $value->stock }}</td>
                                        <td>{{ $value->type_product_name }}</td>
                                        <td>{{ $value->status_name }}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="{{ route('products.edit', $value->id) }}">Información general</a>
                                                    <a class="dropdown-item" href="#">Ver movimientos</a>
                                                    <a class="dropdown-item" href="#" onclick="deleteProduct({{ $value->id }});">Eliminar producto</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach