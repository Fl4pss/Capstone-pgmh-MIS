from flask import Flask, request, jsonify
import tensorflow as tf
from tensorflow.keras.preprocessing import image
import numpy as np
import os

app = Flask(__name__)

model = tf.keras.models.load_model('rock_paper_scissors_model.h5')

def prepare_image(img):
    img = img.resize((64, 64)) 
    img = np.array(img) / 255.0  
    img = np.expand_dims(img, axis=0)  
    return img

@app.route('/predict', methods=['POST'])
def predict():
    if 'image' not in request.files:
        return jsonify({'error': 'No file part'}), 400
    
    file = request.files['image']
    if file.filename == '':
        return jsonify({'error': 'No selected file'}), 400

    try:
        img = image.load_img(file)
        img = prepare_image(img)

        # Make the prediction
        prediction = model.predict(img)
        class_idx = np.argmax(prediction, axis=1)[0]

        # Map class index to class label
        classes = ['rock', 'paper', 'scissors']
        predicted_class = classes[class_idx]

        return jsonify({'prediction': predicted_class})
    
    except Exception as e:
        return jsonify({'error': str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True)
