import os
from keras.preprocessing.image import ImageDataGenerator

os.makedirs('dummy_train/Lurus', exist_ok=True)
os.makedirs('dummy_train/Bergelombang', exist_ok=True)
os.makedirs('dummy_train/Keriting', exist_ok=True)
os.makedirs('dummy_train/Gimbal', exist_ok=True)
os.makedirs('dummy_train/Kribo', exist_ok=True)

with open('dummy_train/Lurus/1.jpg', 'w') as f: f.write('1')
with open('dummy_train/Bergelombang/1.jpg', 'w') as f: f.write('1')
with open('dummy_train/Keriting/1.jpg', 'w') as f: f.write('1')
with open('dummy_train/Gimbal/1.jpg', 'w') as f: f.write('1')
with open('dummy_train/Kribo/1.jpg', 'w') as f: f.write('1')

gen = ImageDataGenerator().flow_from_directory('dummy_train')
print(gen.class_indices)
