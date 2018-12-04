<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Supplier;
use Auth;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Liệt kê danh sách các nhà cung cấp
        // Nếu đã đăng nhập va là admin thì trả về danh sách nhà cung cấp
        if (Auth::user() && Auth::user()->isAdmin()) {
            // Lấy danh sách nhà cung cấp
            $suppliers = Supplier::withTrashed()->get();
            // Trả về danh sách nhà cung cấp cho người dùng
            return Response::json($suppliers, 200);
        }
        // Nếu chưa đăng nhập hoặc không phải admin thì thông báo không có quyền truy cập
        return Response::json(['message' => 'Bạn không có quyền truy cập'], 403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Cái phương thức này không cần dùng đến (mặc định lúc tạo file sẽ có)
        return Response::json(['message' => 'Trang không tồn tại'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Phương thức để lưu nhà cung cấp vào cơ sở dữ liệu
        // Nếu đã đăng nhập và có quyền tạo thêm nhà cung cấp
        if (Auth::user() && Auth::user()->can('create', Supplier::class)) {
            // Lấy data từ form tạo nhà cung cấp
            $data = $request->all();
            // Tiến hành tạo nhà cung cấp từ data đã có
            try {
                // Tạo nhà cung cấp từ data đã có rồi lưu vào biến $supplier
                $supplier = Supplier::create($data);
                // Trả về thông báo tạo thành công
                return Response::json(['message' => 'Tạo nhà cung cấp thành công'], 200);
            } catch(Exception $errors) {
                // Nếu xảy ra lỗi thì thông báo lỗi
                return Response::json(['message' => 'Có lỗi xảy ra. Vui lòng thử lại sau'], 500);
            }
        }
        // Nếu không có quyền tạo mới hoặc chưa đăng nhập thì thông báo lỗi
        return Response::json(['message' => 'Bạn không có quyền truy cập'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // Phương thức dùng để xem chi tiết nhà cung cấp
        // Tìm kiếm nhà cung cấp có tên là $slug. Lấy ra nhà cung cấp đấy cùng với những hóa đơn nhập hàng từ nhà cung cấp đấy
        // gán vào biến $supplier
        $supplier = Supplier::whereSlug($slug)->with('imports')->firstOrFail();
        // Nếu người dùng đã đăng nhập và có quyền xem
        if (Auth::user() && Auth::user()->can('view', $supplier)) {
            // Trả về dữ liệu của nhà cung cấp
            return Response::json($supplier, 200);
        }
        // Nếu chưa đăng nhập hoặc không có quyền thì thông báo lỗi
        return Repsonse::json(['message' => 'Bạn không có quyền truy cập'], 403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        // Phương thức để load thông tin nhà cung cấp. Đưa lên form để chỉnh sửa
        // Lấy thông tin nhà cung cấp có tên là $slug rồi gán vào biến $supplier
        $supplier = Supplier::whereSlug($slug)->firstOrFail();
        // Nếu đã đăng nhập và có quyền chỉnh sửa nhà cung cấp
        if (Auth::user() && Auth::user()->can('update', $supplier)) {
            // trả về thông tin của nhà cung cấp để hiển thị lên form chỉnh sửa1
            return Response::json($supplier, 200);
        }
        // Nếu chưa đăng nhập hoặc không có quyền truy câp thì thông báo lỗi
        return Response::json(['message' => 'Bạn không có quyền truy cập'], 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Phương thức lưu dữ liệu mới (đã chỉnh sửa) của nhà cung cấp vào database
        // Lấy dữ liệu của nhà cung cấp có id là $id gán vào biến $supplier
        $supplier = Supplier::find($id);
        // Nếu người dùng đã đăng nhập và có quyền chỉnh sửa
        if (Auth::user() && Auth::user()->can('update', $supplier)) {
            // Lấy data từ form chỉnh sửa của người dùng (chỉ cần chỉnh sửa mỗi tên nên lấy mỗi name)
            $data = $request->only('name');
            // Tiến hành chỉnh sửa nhà cung cấp
            try {
                // Gán tên nhà cung cấp bằng tên mới
                $supplier->name = $data['name'];
                // Chỉnh sửa slug của nhà cung cấp theo tên mới
                $supplier->slug = str_slug($data['name']);
                // Lưu thay đổi vào cơ sở dữ liệu
                $supplier->save();
                // Trả về thông báo chỉnh sửa thành công
                return Response::json(['message' => 'Đã cập nhật thành công'], 200);
            } catch (Exceptio $errors) {
                // Nếu xảy ra lỗi thì thông báo lỗi
                return Response::json(['message' => 'Có lỗi xảy ra. Vui lòng thử lại sau'], 500);
            }
        }
        // Nếu không có quyền truy cập thì thông báo không có quyền truy cập
        return Response::json(['message' => 'Bạn không có quyền truy cập'], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Phương thức xóa nhà cung cấp (chỉ thay đổi trạng thái từ null sang đã xóa - vẫn tồn tại trong cơ sở dữ liệu)
        // Tìm nhà cung cấp với id là $id lưu vào biến $supplier
        $supplier = Supplier::find($id);
        // Nếu người dùng đã đăng nhập và có quyền xóa nhà cung cấp
        if (Auth::user() && Auth::user()->can('delete', $supplier)) {
            // Tiến hành xóa nhà cung cấp (thay đổi trạng thái sang đã xóa)
            $supplier->delete();
            // Trả về thông báo thành công
            return Repsonse::json(['message' => 'Đã xóa nhà cung cấp'], 200);
        }
        // Nếu chưa đăng nhập hoặc không có quyền xóa nhà cung cấp thì thông báo lỗi
        return Response::json(['message' => 'Bạn không có quyền truy cập'], 403);
    }
}
