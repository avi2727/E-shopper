export interface Product {
    id: number;
    name: string;
    description: string;
    price: number;
    availability: number;
    category_id: number;
    location: string;
    size: string;
    color: string;
    information: string;
    Supercategory_id: number;
    trandy: number;
    justArrived: number;
    product_image: string;
    created_at?: string;
    updated_at?: string;
}

export interface CartItem {
    user_id: number | null;
    cart_id: number;
    product_id: number;
    name: string;
    price: number;
    quantity: number;
    total_price: number;
    product_image: string;
}
