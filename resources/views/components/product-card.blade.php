<div class="col-lg-3 col-md-6 col-12">
    <div class="product-card">
        <div class="product-image">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
            @if ($product->sale_percent != null)
                <div class="sale">
                    <span>-{{ $product->sale_percent }}%</span>
                </div>
            @endif
            <div class="button">
                <a href="product-details.html" class="btn">
                    <i class="lni lni-cart"></i> Add to Cart
                </a>
            </div>
        </div>
        <div class="product-info">
            <span class="category">{{ $product->category->name }}</span>
            <h4 class="title">
                <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
            </h4>
            <div class="review">
                <div class="stars">
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star"></i>
                </div>
                <div class="review-count">
                    4.0 Review(s)
                </div>
            </div>
            <div class="price">
                <span>{{ Currency::format($product->price) }}</span>
                @if ($product->compare_price != null)
                    <span class="compare-price">{{ Currency::format($product->compare_price) }}</span>
                @endif

            </div>
        </div>
    </div>
</div>

<style>
    .product-card {
        width: 300px;
        /* Adjust width as needed */
        height: 450px;
        /* Adjust height as needed */
        border: 1px solid #ddd;
        /* Optional: visual border */
        overflow: hidden;
        display: flex;
        flex-direction: column;
        margin-bottom: 30px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;

    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    /* Define fixed area for the image */
    .product-image {
        width: 100%;
        height: 350px;
        /* Adjust based on design preference */
        overflow: hidden;
        position: relative;
    }

    /* Style the product image to fill its container uniformly */
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Covers the container, cropping if needed */
    }

    /* Optionally, style the add-to-cart button position */
    .product-image .button {
        position: absolute;
        bottom: 10px;
        /* Adjust spacing as needed */
        left: 50%;
        transform: translateX(-50%);
    }

    /* Style the product info container */
    .product-info {
        padding: 15px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .review {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stars i {
        margin-right: 2px;
        color: #FFD700;
        /* optional: gold color for stars */
    }

    .review-count {
        font-size: 0.9rem;
        color: #666;
    }

    .product-image .button .btn {
        transition: all 0.3s ease;
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        display: inline-block;
        border-radius: 4px;
    }

    .product-image .button .btn:hover {
        background-color: #0056b3;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .price {
        font-weight: 600;
        color: #282829;
    }

    .compare-price {
        text-decoration: line-through;
        color: #888;
    }
    .sale{
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: #f00;
        color: #fff;
        padding: 5px 10px;
        border-radius: 4px;
    }
</style>
