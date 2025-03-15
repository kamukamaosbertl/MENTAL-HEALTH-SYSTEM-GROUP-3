import networkx as nx
import os
import re

def count_cyclomatic_complexity(directory, extensions):
    total_complexity = 0
    file_complexities = {}

    for root, _, files in os.walk(directory):
        for file in files:
            if file.endswith(extensions):
                file_path = os.path.join(root, file)
                try:
                    with open(file_path, 'r', encoding='utf-8', errors='ignore') as f:
                        code = f.read()
                        edges = len(re.findall(r'\b(if|else|for|while|switch|case|catch|&&|\|\|)\b', code))
                        nodes = edges + len(re.findall(r'\b(return|break|continue)\b', code)) + 1
                        complexity = edges - nodes + 2
                        total_complexity += complexity
                        file_complexities[file_path] = complexity
                except Exception as e:
                    print(f"Error reading {file_path}: {e}")

    return total_complexity, file_complexities

if __name__ == "__main__":
    project_directory = input("Enter project directory: ")
    extensions = (".js", ".php", ".html", ".css")  # Typically used in web projects
    total, details = count_cyclomatic_complexity(project_directory, extensions)

    print("\nCyclomatic Complexity per file:")
    for file, complexity in details.items():
        print(f"{file}: {complexity}")

    print(f"\nTotal Cyclomatic Complexity: {total}")
