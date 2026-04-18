import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import { Observable, catchError } from 'rxjs';
import { environment } from 'src/environments/environment.development';
import { BehaviorSubject } from 'rxjs';


@Injectable({
  providedIn: 'root'
})
export class UserdataService {
   userdata:any;
   getApi = environment.apiUrl;
   private userNameSubject = new BehaviorSubject<string | null>("guest");
  userName$ = this.userNameSubject.asObservable();
  constructor(private http:HttpClient) { }
  setUserName(userName: string | null) {
    this.userNameSubject.next(userName);
  }
  autoSignInWithToken(token: any): Observable<any> {
    return this.http.get(this.getApi+'autosignin/'+ token);
  }
  getUserDataApi(): Observable<any> {
     return this.http.get(this.getApi+'student');

  }
  addstudentdata(data:any){
    return this.http.post(this.getApi+'addstudent',data);
  }
  deletedata(id:any){
    return this.http.delete(this.getApi+'deletestudent/'+id);
  }
  editdata(id:any){
    return this.http.get(this.getApi+'editstudent/'+id);
    
  }
  updatedata(data: FormData, id: any){
    return this.http.post(this.getApi+'updatestudent/'+id, data);
  }
  loginUser(data: any){
    return this.http.post(this.getApi+'login', data);
  }

  logoutUser() {
    return this.http.post(this.getApi + 'logout',{});
  }
  // isLoggedin() : boolean{
  //   return !!localStorage.getItem('token');
  // }
  SignupUser(data:any) {
    return this.http.post(this.getApi+'signup', data);
  }
  addproductdata(data:any){
    return this.http.post(this.getApi+'addproduct',data);
  }
  getProductDataApi(): Observable<any> {
    return this.http.get(this.getApi+'product');
 }
 getTrandyProductData(): Observable<any> {
  return this.http.get(this.getApi+'trendy-product');
}
getJustArrivedProductData(): Observable<any> {
  return this.http.get(this.getApi+'just-arrived-product');
}
 deleteproductdata(id:any){
  return this.http.delete(this.getApi+'deleteproduct/'+id);
}
updateproductdata(data: FormData, id: any){
  return this.http.post(this.getApi+'updateproduct/'+id, data);
}
getproductdetails(id: any){
  return this.http.get(this.getApi+'fetch-product-details/'+id);
}
categoryWiseData(category: any){
  return this.http.get(this.getApi+'fetch-product-categorywise/'+category);
}
getProductCount(): Observable<any> {
    return this.http.get(this.getApi+'product-count');
 }
 filterby(priceFilter: any, colorFilter: any, sizeFilter: any, category:any,subcategory:any) {

  const requestBody = [
    { key: 'priceFilter', value: priceFilter },
    { key: 'colorFilter', value: colorFilter },
    { key: 'sizeFilter', value: sizeFilter },
    { key: 'category_id', category },
    { key: 'subcategory', subcategory },
  ];

  return this.http.post(this.getApi + 'fetch-product-filter-wise/', requestBody);
}
addtocart(cartItem: { quantity: number; productId: any; }){
  return this.http.post(this.getApi+'add-to-cart/',cartItem);
}
// getcartdetails(userId:any){
//   return this.http.get(this.getApi+'fetch-cart-details/'+ userId);
// }
getcartdetails(userId: any) {
  return this.http.get(this.getApi + 'fetch-cart-details/' + userId).pipe(
    catchError((error: any) => {
      console.error("Error fetching cart details:", error);
      return [];
    })
  );
}

updateCartItem(item:any){
   return this.http.post(this.getApi+'update-cart-details/',item);
}
insertCartData(userId: any, cartDataForBackend: any) {
  const requestData = {
    userId: userId,
    cartData: cartDataForBackend
  };

  return this.http.post(this.getApi + 'insert-cart-details/', requestData);
}
removeCartItem(cart_id:any,user_id:any){
  const requestData = {
    cart_id: cart_id,
    user_id: user_id
  };
  return this.http.post(this.getApi + 'remove-cart-details/', requestData);
}
updatecheckoutdata(formDataToSend: any) {
  return this.http.post(this.getApi + 'checkoutItems-details/', { formDataToSend });
}
// getcartdetailsforSession(data: any) {
//   return this.http.post(this.getApi + 'get-Product-details/', { cartItems: data });
// }
}
