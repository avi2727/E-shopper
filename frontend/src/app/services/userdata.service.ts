import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, BehaviorSubject, catchError, map, of } from 'rxjs';
import { environment } from 'src/environments/environment.development';
import { Product, CartItem } from '../models/product.interface';

@Injectable({
  providedIn: 'root'
})
export class UserdataService {
  private apiUrl = environment.apiUrl;
  
  private userNameSubject = new BehaviorSubject<string | null>("guest");
  userName$ = this.userNameSubject.asObservable();

  constructor(private http: HttpClient) { }

  setUserName(userName: string | null) {
    this.userNameSubject.next(userName);
  }

  // --- Auth & User ---
  autoSignInWithToken(token: string): Observable<any> {
    return this.http.get(`${this.apiUrl}autosignin/${token}`);
  }

  loginUser(data: any): Observable<any> {
    return this.http.post(`${this.apiUrl}login`, data);
  }

  logoutUser(): Observable<any> {
    return this.http.post(`${this.apiUrl}logout`, {});
  }

  signupUser(data: any): Observable<any> {
    return this.http.post(`${this.apiUrl}signup`, data);
  }

  // --- User List Management ---
  getUsers(): Observable<any> {
    return this.http.get(`${this.apiUrl}users`);
  }

  addUser(data: any): Observable<any> {
    return this.http.post(`${this.apiUrl}users`, data);
  }

  deleteUser(id: any): Observable<any> {
    return this.http.delete(`${this.apiUrl}users/${id}`);
  }

  updateUser(id: any, data: FormData): Observable<any> {
    return this.http.post(`${this.apiUrl}users/${id}`, data);
  }

  // --- Product Management ---
  getProductData(): Observable<Product[]> {
    return this.http.get<any>(`${this.apiUrl}product`).pipe(
      map(res => res.data || res) // Handle both raw array and Resource collection wrapper
    );
  }

  getTrendyProducts(): Observable<Product[]> {
    return this.http.get<any>(`${this.apiUrl}trendy-product`).pipe(
      map(res => res.data || res)
    );
  }

  getJustArrivedProducts(): Observable<Product[]> {
    return this.http.get<any>(`${this.apiUrl}just-arrived-product`).pipe(
      map(res => res.data || res)
    );
  }

  getProductDetails(id: number): Observable<Product[]> {
    return this.http.get<Product[]>(`${this.apiUrl}fetch-product-details/${id}`);
  }

  addProduct(data: FormData): Observable<any> {
    return this.http.post(`${this.apiUrl}addproduct`, data);
  }

  updateProduct(id: number, data: FormData): Observable<any> {
    return this.http.post(`${this.apiUrl}updateproduct/${id}`, data);
  }

  deleteProduct(id: number): Observable<any> {
    return this.http.delete(`${this.apiUrl}deleteproduct/${id}`);
  }

  getCategoryProducts(category: number): Observable<Product[]> {
    return this.http.get<any>(`${this.apiUrl}fetch-product-categorywise/${category}`).pipe(
      map(res => res.data || res)
    );
  }

  getProductCount(): Observable<any> {
    return this.http.get(`${this.apiUrl}product-count`);
  }

  filterProducts(priceFilter: string, colorFilter: string, sizeFilter: string, category: any, subcategory: any): Observable<Product[]> {
    const filters = [
      { key: 'priceFilter', value: priceFilter },
      { key: 'colorFilter', value: colorFilter },
      { key: 'sizeFilter', value: sizeFilter },
      { key: 'category_id', category },
      { key: 'subcategory', subcategory },
    ];
    return this.http.post<any>(`${this.apiUrl}fetch-product-filter-wise/`, filters).pipe(
      map(res => res.data || res)
    );
  }

  // --- Cart Management ---
  addToCart(cartItem: { quantity: number; productId: number; userId?: string | number | null }): Observable<any> {
    return this.http.post(`${this.apiUrl}add-to-cart/`, cartItem);
  }

  getCartDetails(userId: string | number | null): Observable<{ cart_items: CartItem[], cart_item_count: number }> {
    return this.http.get<any>(`${this.apiUrl}fetch-cart-details/${userId}`).pipe(
      catchError((error) => {
        console.error("Error fetching cart details:", error);
        return of({ cart_items: [], cart_item_count: 0 });
      })
    );
  }

  updateCartItem(item: { cart_id: number; quantity: number }): Observable<any> {
    return this.http.post(`${this.apiUrl}update-cart-details/`, item);
  }

  syncCartAfterLogin(userId: number, cartData: any[]): Observable<any> {
    return this.http.post(`${this.apiUrl}insert-cart-details/`, { userId, cartData });
  }

  removeCartItem(cart_id: number, user_id: number | null): Observable<any> {
    return this.http.post(`${this.apiUrl}remove-cart-details/`, { cart_id, user_id });
  }

  checkout(formDataToSend: any): Observable<any> {
    return this.http.post(`${this.apiUrl}checkoutItems-details/`, { formDataToSend });
  }
}
