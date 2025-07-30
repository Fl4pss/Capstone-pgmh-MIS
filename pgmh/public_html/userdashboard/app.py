from flask import Flask, request, jsonify
import tensorflow as tf
from tensorflow.keras.preprocessing import image
import numpy as np
from PIL import Image
from flask_cors import CORS  # Import CORS

app = Flask(__name__)
CORS(app)  # Enable CORS for the app

# Load the trained model
model = tf.keras.models.load_model('rock_paper_scissors_model.h5')

# Define a function to preprocess the image for prediction
def preprocess_image(img):
    img = img.resize((64, 64))  # Resize image to match the model input
    img = np.array(img) / 255.0  # Normalize image
    img = np.expand_dims(img, axis=0)  # Add batch dimension
    return img

@app.route('/predict', methods=['POST'])
def predict():
    # Check if the request contains an image
    if 'image' not in request.files:
        return jsonify({'error': 'No image file provided'}), 400

    img_file = request.files['image']
    try:
        img = Image.open(img_file)  # Open the image
    except Exception as e:
        return jsonify({'error': f'Error processing image: {str(e)}'}), 400

    # Preprocess the image
    img_array = preprocess_image(img)
    
    # Make prediction
    prediction = model.predict(img_array)
    class_idx = np.argmax(prediction)
    
    # Map class index to label
    result = {0: 'Rock', 1: 'Paper', 2: 'Scissors'}
    
    return jsonify({'prediction': result[class_idx]})

if __name__ == '__main__':
    app.run(debug=True, port=5000)  # Ensure it's running on port 5000
